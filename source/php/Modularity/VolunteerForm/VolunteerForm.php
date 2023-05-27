<?php /** @noinspection PhpUndefinedClassInspection */

/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\VolunteerForm;

use APIVolunteerManagerIntegration\Helper\CacheBust;
use Modularity\Module;

/**
 * @property string $nameSingular
 * @property string $namePlural
 * @property string $description
 */
class VolunteerForm extends Module
{
    public string $slug = 'mod-volunteer-form';
    public array $supports = [];

    public function init()
    {
        $this->nameSingular = __('Volunteer Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Volunteer Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
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
        return 'volunteer-form.blade.php';
    }

    public function script()
    {
        wp_enqueue_script(
            'register-volunteer-form-js',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/volunteer-form.js'),
            ['gdi-host']
        );

        wp_enqueue_style(
            'register-volunteer-form-css',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/volunteer-form.css')
        );
    }
}