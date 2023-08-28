<?php

namespace APIVolunteerManagerIntegration\Import;

class Setup
{
    public function __construct()
    {
        //Add manual import button(s)
        add_action('restrict_manage_posts', [$this, 'addImportButton'], 100);

        add_action('admin_init', [$this, 'importPosts']);

        /* Register cron action */
        //add_action('import_projects_daily', [$this, 'projectEventsCron']);

        /* WP WebHooks */
        //add_filter('wpwhpro/run/actions/custom_action/return_args', [$this, 'triggerImport'], 10, 3);
    }

    public static function addCronJob()
    {
        wp_schedule_event(time(), 'hourly', 'import_projects_daily');
    }

    public static function removeCronJob()
    {
        wp_clear_scheduled_hook('import_projects_daily');
    }

    public function triggerImport($response, $identifier, $payload)
    {
        if ($identifier !== 'importProject') {
            return $response;
        }

        if (
            ! isset($payload['content'])
            || ! isset($payload['content']->post)
            || ! isset($payload['content']->post->post_type)
        ) {
            $response['msg'] = 'PostType data is missing';

            return $response;
        }

        $importerClassName = $this->getImporterClassNameByPostType($payload['content']->post->post_type);

        if ( ! $importerClassName) {
            $response['msg'] = 'Importer Class does not exist: '.$importerClassName;

            return $response;
        }

        $postType = $payload['content']->post->post_type;

        $baseUrl = get_field('project_api_url', 'option');
        $url     = $baseUrl.'/'.$postType;

        $Importer = new $importerClassName($url, $payload['content']->post->ID);

        $response['msg'] = 'Updated post '.$payload['content']->post->ID;

        if (empty($Importer->addedPostsId)) {
            $response['msg'] = 'Project ID does not exists'.$payload['content']->post->ID;
        }

        return $response;
    }

    public function getImporterClassNameByPostType($postType)
    {
        $namespace = '\APIVolunteerManagerIntegration\Import\\';
        $className = apply_filters('APIVolunteerManagerIntegration/Import/Setup::getImporterClassNameByPostType',
            $namespace.ucwords($postType), $postType);

        var_dump($className);
        if (class_exists($className)) {
            return $className;
        }

        return false;
    }

    public function importPosts()
    {
        if (
            ! isset($_GET['import_assignments'])
            || empty($_GET['post_type'])
        ) {
            return;
        }


        $baseUrl = get_field('volunteer_manager_integration_api_uri', 'option');
        $url     = $baseUrl.'/assignment';

        new Assignment($url);
    }

    /**
     * Add manual import button
     * @return bool|null
     */
    public function addImportButton()
    {
        global $wp;

        $postType = get_current_screen()->post_type;

        if (empty($postType) || $postType !== 'vol-assignment') {
            return;
        }

        $queryArgs = array_merge($wp->query_vars, ['import_assignments' => 'true']);
        echo '<a href="'.add_query_arg('import_assignments', 'true',
                $_SERVER['REQUEST_URI']).'" class="button-primary extraspace" style="float: right; margin-right: 10px;">'.__("Import posts",
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).'</a>';
    }

    /**
     * Start cron jobs
     * @return void
     */
    public function projectEventsCron()
    {
        $url = get_field('volunteer_manager_integration_api_uri', 'option').'/assignment';

        new Assignment($url);
    }
}
