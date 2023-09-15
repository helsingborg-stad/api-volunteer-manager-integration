<?php
/** @noinspection PhpMissingFieldTypeInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\VolunteerForm;

use APIVolunteerManagerIntegration\Helper\CacheBust;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use APIVolunteerManagerIntegration\Services\MyPages\MyPagesService;

/**
 * @property string $nameSingular
 * @property string $namePlural
 * @property string $description
 * @property int $ID
 */
class VolunteerForm extends \Modularity\Module
{
    public $slug = 'mod-volunteer-form';
    public $supports = [];

    private MyPages $myPages;

    public function init()
    {
        $this->nameSingular = __('Volunteer Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Volunteer Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->description  = __('Module for Volunteer registration form',
            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);

        $this->myPages = new MyPagesService();
    }


    public function data(): array
    {
        return [
            'loginDialog'             => [
                'heading' => __('Volunteer Registration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'id'      => 'identification-dialog',
                'buttons' => [
                    [
                        'text'      => __('Identify with Bank ID', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'href'      => $this->myPages->loginUrl(get_permalink().'?'.http_build_query(['is_authenticated' => 1])),
                        'color'     => 'primary',
                        'style'     => 'filled',
                        'fullWidth' => true,
                    ],
                ],
            ],
            'registerVolunteerDialog' => ! empty($_GET['is_authenticated']) ?
                [
                    'heading'               => __('Volunteer Registration',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'id'                    => 'volunteer-registration-dialog',
                    'registerVolunteerForm' => [
                        'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
                        'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
                        'labels'             => [
                            'form_terms' => get_field('form_terms', $this->ID) ?: '',
                        ],
                        'signOutUrl'         => $this->myPages->signOutUrl(),
                    ],
                ]
                : [],
        ];
    }

    public function template(): string
    {
        return 'volunteer-form.blade.php';
    }

    public function script()
    {
        if ( ! $this->hasModule()) {
            return;
        }

        wp_enqueue_script(
            'register-volunteer-form-js',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/volunteer-form.js'),
            ['gdi-host', 'mod-my-pages-js']

        );

        wp_enqueue_style(
            'register-volunteer-form-css',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('js/volunteer-form.css')
        );
    }
}