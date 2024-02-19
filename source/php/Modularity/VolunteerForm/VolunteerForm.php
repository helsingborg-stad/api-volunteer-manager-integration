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
    
    private $ttl;
    private MyPages $myPages;

    public function init()
    {
        $this->nameSingular = __('Volunteer Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Volunteer Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->description  = __('Module for Volunteer registration form',
            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->ttl          = false;
        $this->myPages      = new MyPagesService();
    }


    public function data(): array
    {
        return [
            'loginDialog'             => [
                'heading'            => __('Volunteer Registration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'id'                 => 'identification-dialog',
                'text'               => __('Identify with Bank ID to continue.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'buttons'            => [
                    [
                        'text'      => __('Identify with Bank ID', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'href'      => $this->myPages->loginUrl(get_permalink().'?'.http_build_query(['is_authenticated' => 1])),
                        'color'     => 'primary',
                        'style'     => 'filled',
                        'fullWidth' => true,
                    ],
                ],
                'triggerButtonLabel' => __('Volunteer Registration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            ],
            'registerVolunteerDialog' => [
                'heading'               => __('Volunteer Registration',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'id'                    => 'volunteer-registration-dialog',
                'registerVolunteerForm' => [
                    'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
                    'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
                    'labels'             => [
                        'form_terms'                                    => get_field('form_terms', $this->ID) ?: '',
                        'field_label_volunteer_phone'                   => __('Phone',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'button_label_submit'                           => __('Submit',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_label_volunteer_email'                   => __('E-mail',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_label_volunteer_name'                    => __('Name',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'loading_text'                                  => __('Loading',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'saving_text'                                   => __('Saving',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'sending_text'                                  => __('Sending',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'error_text'                                    => __('Something went wrong, please try again later.',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'success_text'                                  => __('Thank you! We will get in touch with you as soon as possible.',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'select_placeholder'                            => __('Select an option',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_label_volunteer_newsletter'              => __('Newsletter',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_option_label_volunteer_newsletter_true'  => __('Yes I want to receive the newsletter',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_option_label_volunteer_newsletter_false' => __('No, I do not want to receive the newsletter',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_label_volunteer_terms'                   => __('Volunteer Terms',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_option_label_volunteer_terms_accept'     => __('I have read and agree to the terms and conditions for being a volunteer'                                ,
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                        'field_helper_text_volunteer_terms'             => get_field('volunteer_terms', $this->ID) ?: '',
                    ],
                    'signOutUrl'         => $this->myPages->signOutUrl(),
                ],
            ],
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