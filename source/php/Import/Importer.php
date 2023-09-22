<?php

namespace APIVolunteerManagerIntegration\Import;

use APIVolunteerManagerIntegration\Helper\Request;

class Importer
{
    public $url;
    public $postType = 'vol-assignment';
    public $addedPostsId = [];
    private $localTerms = [];
    private $taxonomies = [];

    public function __construct($url, $postId = false)
    {
        ini_set('max_execution_time', 3000);

        $this->url = $url;

        if (method_exists($this, 'init')) {
            $this->init();
        }

        if ($postId) {
            $this->importPost($postId);
        } else {
            $this->importPosts();
        }
    }

    public function importPost($postId)
    {
        if (function_exists('kses_remove_filters')) {
            kses_remove_filters();
        }

        $url = $this->url.'/'.$postId.'?acf_format=standard';

        $requestResponse = Request::get($url);

        if (is_wp_error($requestResponse)) {
            error_log(print_r($url, true));
            error_log(print_r($requestResponse, true));

            return;
        }

        $this->savePost($requestResponse['body']);
    }

    public function savePost($post)
    {
        extract($post);

        //Get matching post
        $postObject = $this->getPost(
            [
                'key'   => 'uuid',
                'value' => $id,
            ]
        );

        // Collect post meta
        $postMeta = $this->mapMetaKeys($post);
        // Collect taxonomies
        $postTaxonomies = $this->mapTaxonomies($post);

        // Not existing, create new
        if ( ! isset($postObject->ID)) {
            $postData = [
                'post_title'         => $title['rendered'] ?? $title ?? '',
                'post_content'       => $content['rendered'] ?? $content ?? '',
                'post_name'          => $slug,
                'post_type'          => $this->postType,
                'post_status'        => 'publish',
                'post_date'          => $date ?? $created ?? '',
                'post_date_gmt'      => $date_gmt ?? $created_gmt ?? '',
                'post_modified'      => $modified ?? '',
                'post_date_modified' => $modified_gmt ?? '',
                'menu_order'         => $menu_order ?? 0,
            ];
            $postId   = wp_insert_post($postData);

            if ( ! is_wp_error($postId)) {
                $this->addedPostsId[] = $postId;
            }
        } else {
            // Post already exist, do updates

            // Get post object id
            $postId = $postObject->ID;

            $this->addedPostsId[] = $postId;


            $remotePost = [
                'ID'                 => $postId,
                'post_title'         => $title['rendered'] ?? $title ?? '',
                'post_content'       => $content['rendered'] ?? $content ?? '',
                'post_name'          => $slug,
                'post_date'          => $date ?? $created ?? '',
                'post_date_gmt'      => $date_gmt ?? $created_gmt ?? '',
                'post_modified'      => $modified ?? '',
                'post_date_modified' => $modified_gmt ?? '',
                'menu_order'         => $menu_order ?? 0,
            ];

            $localPost = [
                'ID'                 => $postId,
                'post_title'         => $postObject->post_title,
                'post_content'       => $postObject->post_content,
                'post_name'          => $postObject->post_name,
                'post_date'          => $postObject->date ?? '',
                'post_date_gmt'      => $postObject->date_gmt ?? '',
                'post_modified'      => $postObject->modified ?? '',
                'post_date_modified' => $postObject->modified_gmt ?? '',
                'menu_order'         => $postObject->menu_order ?? 0,
            ];

            // Update if post object is modified
            if ($localPost !== $remotePost) {
                wp_update_post($remotePost);
            }
        }

        if ( ! ($modified === get_post_meta($postId, 'last_modified', true))) {
            $this->updateFeatureImage($post, $postId);
        }

        // Update post meta data
        $this->updatePostMeta($postId, $postMeta);
        // Update taxonomies
        $this->updateTaxonomies($postId, $postTaxonomies);
    }

    /**
     *  Get posts
     *
     * @param $search
     *
     * @return mixed|null
     */
    public function getPost($search, $postType = '')
    {
        $post = get_posts(
            [
                'meta_query'     => [
                    [
                        'key'   => $search['key'],
                        'value' => $search['value'],
                    ],
                ],
                'post_type'      => ! empty($postType) ? $postType : $this->postType,
                'posts_per_page' => 50,
                'post_status'    => 'all',
            ]
        );

        if ( ! empty($post) && is_array($post)) {
            $post = array_pop($post);
            if (isset($post->ID) && is_numeric($post->ID)) {
                return $post;
            }
        }

        return null;
    }

    // Remove post that got deleted in the project manager (source that this API copies).

    public function mapMetaKeys($post)
    {
        extract($post);

        $data = [
            'uuid'          => $post['id'] ?? null,
            'last_modified' => $post['modified'] ?? null,
        ];

        return $data;
    }

    public function mapTaxonomies($post)
    {
        extract($post);

        $data             = [];
        $this->taxonomies = array_keys($data);

        return $data;
    }

    /**
     * Update if any feature image found.
     */
    public function updateFeatureImage($post, $idOfCopyPost)
    {
        extract($post);

        // TODO: Fix naive fetching of JSON elemetns.
        if (
            ! isset($_links['wp:featuredmedia'])
            || ! is_array($_links['wp:featuredmedia'])
            || ! isset($_links['wp:featuredmedia'][0])
            || ! isset($_links['wp:featuredmedia'][0]['href'])
        ) {
            return;
        }

        $fimg_api_url = $_links['wp:featuredmedia'][0]['href'];

        if ( ! isset($fimg_api_url) || strlen($fimg_api_url) === 0 || ! filter_var($fimg_api_url,
                FILTER_VALIDATE_URL)) {
            // Did not find valid href for feature image,
            return;
        }

        $fimg_api_res = Request::get($fimg_api_url);

        if (is_wp_error($fimg_api_res)) {
            return;
        }

        $fimg_url = $fimg_api_res['body']['source_url'];

        if (is_string($fimg_url)) {
            $this->setFeaturedImageFromUrl($fimg_url, $idOfCopyPost);
        }
    }

    /**
     * Uploads an image from a specified url and sets it as the current post's featured image
     *
     * @param  string  $url  Image url
     *
     * @return bool|void
     */
    public function setFeaturedImageFromUrl($url, $id)
    {
        // Fix for get_headers SSL errors (https://stackoverflow.com/questions/40830265/php-errors-with-get-headers-and-ssl)
        stream_context_set_default([
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]);

        $headers = get_headers($url, 1);

        if (empty($url) || preg_match('/200 OK/', $headers[0]) === 0) {
            return false;
        }

        // TODO: Set correct uploadDir.
        // Upload paths
        $uploadDir = wp_upload_dir();
        $uploadDir = $uploadDir['basedir'];
        $uploadDir = $uploadDir.'/volunteer_manager';

        if ( ! is_dir($uploadDir)) {
            if ( ! mkdir($uploadDir, 0776)) {
                error_log('could not crate folder');

                return new WP_Error('event', __(
                                                 'Could not create folder',
                                                 'event-manager'
                                             ).' "'.$uploadDir.'", '.__(
                                                 'please go ahead and create it manually and rerun the import.',
                                                 'event-manager'
                                             ));
            }
        }

        $filename = sanitize_file_name(basename($url));

        if (stripos(basename($url), '.aspx')) {
            $filename = md5($filename).'.jpg';
        }

        // Bail if image already exists in library
        if ($attachmentId = $this->attachmentExists($uploadDir.'/'.basename($filename))) {
            set_post_thumbnail((int) $id, (int) $attachmentId);

            return;
        }

        // Save file to server
        $contents = file_get_contents($url);
        $save     = fopen($uploadDir.'/'.$filename, 'w');
        fwrite($save, $contents);
        fclose($save);

        // Detect file type
        $filetype = wp_check_filetype($filename, null);

        // Insert the file to media library
        $attachmentId = wp_insert_attachment([
            'guid'           => $uploadDir.'/'.basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title'     => $filename,
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $id,
        ], $uploadDir.'/'.$filename, $id);

        // Generate attachment meta
        require_once(ABSPATH.'wp-admin/includes/image.php');
        $attachData = wp_generate_attachment_metadata($attachmentId, $uploadDir.'/'.$filename);
        wp_update_attachment_metadata($attachmentId, $attachData);

        set_post_thumbnail($id, $attachmentId);
    }

    /**
     * Checks if a attachment src already exists in media library
     *
     * @param  string  $src  Media url
     *
     * @return mixed
     */
    private function attachmentExists($src)
    {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$src'";
        $id    = $wpdb->get_var($query);

        if ( ! empty($id) && $id > 0) {
            return $id;
        }

        return false;
    }

    /**
     *  Update post meta
     *
     * @param $postId
     * @param $dataObject
     *
     * @return bool
     */
    public function updatePostMeta($postId, $dataObject)
    {
        if (is_array($dataObject) && ! empty($dataObject)) {
            foreach ($dataObject as $metaKey => $metaValue) {
                if ($metaKey == "") {
                    continue;
                }

                if ($metaValue !== get_post_meta($postId, $metaKey, true)) {
                    update_post_meta($postId, $metaKey, $metaValue);
                }
            }

            return true;
        }

        return false;
    }

    public function updateTaxonomies($postId, $taxonomies)
    {
        foreach ($taxonomies as $taxonomyKey => $taxonomy) {
            // Remove previous connections
            wp_delete_object_term_relationships($postId, $taxonomyKey);

            if (empty($taxonomy) || ! is_array($taxonomy)) {
                continue;
            }

            $termList = [];

            foreach ($taxonomy as $key => $term) {
                // Check if term exist
                $localTerm = term_exists($term['slug'], $taxonomyKey);

                $metaKeys = $this->mapTermMetaKeys($term);

                if ($localTerm) {
                    $localTermObject = get_term($localTerm['term_id'], $taxonomyKey);

                    // Check if taxonomy name needs to be updated.
                    if ($term['name'] !== $localTermObject->name) {
                        wp_update_term(
                            $localTermObject->term_id,
                            $localTermObject->taxonomy,
                            [
                                'name' => $term['name'],
                            ]
                        );
                    }

                    // Check if taxonomy description needs to be updated.
                    if ($term['description'] !== $localTermObject->description) {
                        wp_update_term(
                            $localTermObject->term_id,
                            $localTermObject->taxonomy,
                            [
                                'description' => $term['description'],
                            ]
                        );
                    }
                } elseif ( ! $localTerm) {
                    // Create term if not exist
                    $localTerm = wp_insert_term(
                        $term['name'],
                        $taxonomyKey,
                        [
                            'description' => $term['description'],
                            'slug'        => $term['slug'],
                            'parent'      => ! empty($term['parent']) ? $this->getParentByRemoteId($term['parent'],
                                $term['taxonomy']) : 0,
                        ]
                    );
                }

                if ( ! empty($metaKeys) && ! empty($localTerm['term_id'])) {
                    $this->updateTermMeta($localTerm['term_id'], $metaKeys);
                }

                if (is_array($localTerm) && isset($localTerm['term_id'])) {
                    $termList[] = (int) $localTerm['term_id'];

                    // Save to local terms
                    if ( ! in_array($localTerm['term_id'], $this->localTerms)) {
                        $this->localTerms[] = $localTerm['term_id'];
                    }
                }
            }

            // Connecting term to post
            wp_set_post_terms($postId, $termList, $taxonomyKey, true);
        }
    }

    public function mapTermMetaKeys($term)
    {
        extract($term);


        $data = apply_filters('APIVolunteerManagerIntegration/Import/Importer/metaKeys', [], $term);

        return $data;
    }

    public function getParentByRemoteId($remoteId, $remoteTaxonomy)
    {
        if ($remoteId === 0) {
            return $remoteId;
        }

        $url              = str_replace($this->postType, $remoteTaxonomy, $this->url).'/'.$remoteId;
        $requestResponse  = Request::get($url);
        $remoteParentTerm = $requestResponse['body'];
        $localParentTerm  = get_term_by('slug', $remoteParentTerm['slug'], 'project_'.$remoteTaxonomy, ARRAY_A);

        if (empty($localParentTerm)) {
            $localParentTerm = wp_insert_term(
                $remoteParentTerm['name'],
                'project_'.$remoteParentTerm['taxonomy'],
                [
                    'description' => $remoteParentTerm['description'],
                    'slug'        => $remoteParentTerm['slug'],
                    'parent'      => $this->getParentByRemoteId($remoteParentTerm['parent'],
                        $remoteParentTerm['taxonomy']),
                ]
            );
        }

        return $localParentTerm['term_id'];
    }

    /**
     *  Update post meta
     *
     * @param $postId
     * @param $dataObject
     *
     * @return bool
     */
    public function updateTermMeta($termId, $dataObject)
    {
        if (is_array($dataObject) && ! empty($dataObject)) {
            foreach ($dataObject as $metaKey => $metaValue) {
                if ($metaKey == "") {
                    continue;
                }

                if ($metaValue !== update_term_meta($termId, $metaKey, true)) {
                    update_term_meta($termId, $metaKey, $metaValue);
                }
            }

            return true;
        }

        return false;
    }

    public function importPosts()
    {
        if (function_exists('kses_remove_filters')) {
            kses_remove_filters();
        }

        $filterQueryArgs = [];

        $organisationFilter = get_field('organisation_filter', 'option');
        if ($organisationFilter > 0) {
            $filterQueryArgs['organisation'] = $organisationFilter;
        }

        $totalPages = 1;

        for ($i = 1; $i <= $totalPages; $i++) {
            error_log("Do run: ".$i);

            $url = add_query_arg(
                array_merge(
                    [
                        'page'       => $i,
                        'per_page'   => 50,
                        'acf_format' => 'standard',
                    ],
                    $filterQueryArgs
                ),
                $this->url
            );

            error_log(print_r($url, true));

            $requestResponse = Request::get($url);

            if (is_wp_error($requestResponse)) {
                break;
            }

            $totalPages = $requestResponse['headers']['x-wp-totalpages'] ?? $totalPages;

            $this->savePosts($requestResponse['body']);
        }

        $this->removePosts();
        $this->removeTerms();
    }

    /**
     * Save posts
     * Posts can be filtered (by organisation) before saving.
     *
     * @param $posts
     */
    public function savePosts($posts)
    {
        foreach ($posts as $post) {
            $this->savePost($post);
        }
    }

    private function removePosts()
    {
        if (count($this->addedPostsId) > 0) {
            $entriesToRemove = get_posts([
                'numberposts' => -1,
                'hide_empty'  => false,
                'exclude'     => $this->addedPostsId,
                'post_type'   => $this->postType,
            ]);

            foreach ($entriesToRemove as $entry) {
                $featuredImageId = get_post_thumbnail_id($entry->ID);

                if ( ! empty($featuredImageId)) {
                    wp_delete_post($featuredImageId, true);
                }

                wp_delete_post($entry->ID, true);
            }
        }

        $this->addedPostsId = [];
    }

    private function removeTerms()
    {
        $termsToRemove = get_terms([
            'taxonomy'   => $this->taxonomies,
            'exclude'    => $this->localTerms,
            'hide_empty' => false,
            'childless'  => true,
        ]);

        if ( ! empty($termsToRemove)) {
            foreach ($termsToRemove as $term) {
                if ($term->count === 0) {
                    $deletedTerm = wp_delete_term($term->term_id, $term->taxonomy);

                    if (is_wp_error($deletedTerm)) {
                        error_log(print_r($deletedTerm, true));
                    }
                }
            }
        }
    }

    public function saveTerms()
    {
        $insertAndUpdateId = [];
        $taxonomies        = ['status', 'technology', 'sector', 'organisation', 'global_goal', 'category', 'partner'];

        foreach ($taxonomies as $taxonomie) {
            $url = str_replace('project', $taxonomie, $this->url);

            // Fetch taxonomy from API.
            $totalPages = 1;
            for ($i = 1; $i <= $totalPages; $i++) {
                $url = add_query_arg(
                    [
                        'page'     => 1,
                        'per_page' => 50,
                    ],
                    $url
                );

                $requestResponse = Request::get($url);

                if (is_wp_error($requestResponse)) {
                    break;
                }

                $totalPages = $requestResponse['headers']['x-wp-totalpages'] ?? $totalPages;

                if ( ! $requestResponse['body']) {
                    return;
                }

                // Start import of taxonomies.
                $terms = $requestResponse['body'];

                // Crate term if it does not exist or update existing
                if ( ! empty($terms)) {
                    foreach ($terms as $term) {
                        $localTerm = term_exists($term['slug'], 'project_'.$term['taxonomy']);

                        // Keep track of newly inserted and updated querys. Will be used to delte old entries.
                        $wpInsertUpdateResp = null;

                        // Construct arguments for insert and update querys.
                        $wpInsertUpdateArgs = [
                            'description' => $term['description'],
                            'slug'        => $term['slug'],
                        ];

                        if (isset($term['parent'])) {
                            $wpInsertUpdateArgs['parent'] = ! empty($term['parent']) ? $this->getParentByRemoteId($term['parent'],
                                $term['taxonomy']) : 0;
                        }

                        if ( ! $localTerm) {
                            // Crate term, could not find any existing.
                            $wpInsertUpdateResp = wp_insert_term($term['name'], 'project_'.$term['taxonomy'],
                                $wpInsertUpdateArgs);

                            if ( ! is_wp_error($wpInsertUpdateResp)) {
                                $insertAndUpdateId[] = $wpInsertUpdateResp['term_id'];
                            } else {
                                error_log(print_r($wpInsertUpdateResp, true));
                            }

                            continue;
                        }

                        $wpInsertUpdateArgs['name'] = $term['name'];

                        // Update term, did find existing.
                        $wpInsertUpdateResp = wp_update_term($localTerm['term_id'], 'project_'.$term['taxonomy'],
                            $wpInsertUpdateArgs);

                        if ( ! is_wp_error($wpInsertUpdateResp)) {
                            $insertAndUpdateId[] = $wpInsertUpdateResp['term_id'];
                        } else {
                            error_log(print_r($wpInsertUpdateResp, true));
                        }
                    }
                }
            }
        }

        $removeEntries = get_terms([
            'hide_empty' => false,
            'exclude'    => $insertAndUpdateId,
        ]);


        foreach ($removeEntries as $entries) {
            // TODO: Should we skip root antry?
            if ($entries->term_id === 1 && $entries->taxonomy === 'category') {
                continue;
            }

            wp_delete_term($entries->term_id, $entries->taxonomy);
        }
    }

    public function getRemoteTerm($remoteTermId, $remoteTaxonomy)
    {
        error_log(print_r($remoteTermId, true));
        error_log(print_r($remoteTaxonomy, true));
        $url             = str_replace($this->postType, $remoteTaxonomy, $this->url).'/'.$remoteTermId;
        $requestResponse = Request::get($url);

        error_log(print_r($url, true));

        return $requestResponse['body'];
    }
}
