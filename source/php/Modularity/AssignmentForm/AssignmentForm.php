<?php /** @noinspection PhpUndefinedClassInspection */

/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\AssignmentForm;

use APIVolunteerManagerIntegration\Helper\CacheBust;
use Modularity\Module;

class AssignmentForm extends Module
{
    public $slug = 'mod-v-assign-form';
    public $supports = [];

    public function init()
    {
        $this->nameSingular = __('Assignment Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Assignment Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->description  = __('Module for Volunteer registration form',
            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
    }


    public function data(): array
    {
        return [
            'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
            'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
            'labels'             => [],
        ];
    }

    public function template(): string
    {
        return 'assignment-form.blade.php';
    }

    public function script()
    {
        wp_enqueue_script(
            'register-volunteer-assignment-form-js',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/assignment-form.js'),
            ['gdi-host']
        );
        /*
                wp_enqueue_style(
                    'gdi-modularity-about-me-css',
                    API_VOLUNTEER_MANAGER_INTEGRATION_URL . '/dist/' . CacheBust::name('js/gdi-modularity-about-me.css'),
                    null
                );*/
    }
}