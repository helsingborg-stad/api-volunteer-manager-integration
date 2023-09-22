<?php

namespace APIVolunteerManagerIntegration\Import;

class Setup
{
    public function __construct()
    {
        //Add manual import button(s)
        add_action('restrict_manage_posts', [$this, 'addImportButton'], 100);
        add_action('admin_init', [$this, 'onClickImportButton']);

        /* Cron */
        add_action('plugins_loaded', [$this, 'disableCronJob']);
        add_action('import_volunteer_assignments_daily', [$this, 'importPosts']);
        add_filter('acf/update_value/name=volunteer_assignments_daily_import', [$this, 'toggleCronJob'], 10, 1);

        /* WP WebHooks */
        //add_filter('wpwhpro/run/actions/custom_action/return_args', [$this, 'triggerImport'], 10, 3);
    }

    public function disableCronJob()
    {
        if ( ! get_field('volunteer_assignments_daily_import', 'option')) {
            self::removeCronJob();
        }
    }

    public static function removeCronJob()
    {
        wp_clear_scheduled_hook('import_volunteer_assignments_daily');
    }

    public function toggleCronJob(bool $value): bool
    {
        $value ? self::addCronJob() : self::removeCronJob();

        return $value;
    }

    public static function addCronJob()
    {
        wp_schedule_event(time(), 'hourly', 'import_volunteer_assignments_daily');
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

        if (class_exists($className)) {
            return $className;
        }

        return false;
    }

    public function onClickImportButton()
    {
        if (
            ! isset($_GET['import_assignments'])
            || empty($_GET['post_type'])
            || $_GET['post_type'] !== \APIVolunteerManagerIntegration\PostTypes\Assignment::$postType
        ) {
            return;
        }

        $this->importPosts();
    }

    /**
     * Start cron jobs
     * @return void
     */
    public function importPosts()
    {
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

        if (empty($postType) || $postType !== \APIVolunteerManagerIntegration\PostTypes\Assignment::$postType) {
            return;
        }

        $queryArgs = array_merge($wp->query_vars, ['import_assignments' => 'true']);
        echo '<a href="'.add_query_arg('import_assignments', 'true',
                $_SERVER['REQUEST_URI']).'" class="button-primary extraspace" style="float: right; margin-right: 10px;">'.__("Import posts",
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).'</a>';
    }
}
