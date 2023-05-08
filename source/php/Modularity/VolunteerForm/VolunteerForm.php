<?php /** @noinspection PhpUndefinedClassInspection */

/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\VolunteerForm;

use APIVolunteerManagerIntegration\Helper\CacheBust;
use Modularity\Module;

class VolunteerForm extends Module
{
    public $slug = 'volunteer-form';
    public $supports = [];

    public function init()
    {
        $this->nameSingular = __('Volunteer Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Volunteer Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->description  = __('Module for Volunteer registration form',
            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
    }


    public function data(): array
    {
        return [];
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
            null
        );
        /*
                wp_enqueue_style(
                    'gdi-modularity-about-me-css',
                    API_VOLUNTEER_MANAGER_INTEGRATION_URL . '/dist/' . CacheBust::name('js/gdi-modularity-about-me.css'),
                    null
                );*/
    }
}