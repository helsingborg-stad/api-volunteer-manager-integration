<?php
/** @noinspection PhpMissingFieldTypeInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\AssignmentForm;

use APIVolunteerManagerIntegration\Helper\CacheBust;

/**
 * @property string $description
 * @property string $namePlural
 * @property string $nameSingular
 * @property int $ID
 */
class AssignmentForm extends \Modularity\Module
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
            'labels'             => [
                'form_terms' => get_field('form_terms', $this->ID) ?: '',
            ],
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

        wp_enqueue_style(
            'register-volunteer-assignment-form-css',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/assignment-form.css')
        );
    }
}