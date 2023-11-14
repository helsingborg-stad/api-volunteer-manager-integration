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
        $this->ttl          = false;
    }


    public function data(): array
    {
        $optionalFieldLabel = ' ('.__('optional',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).')';

        return [
            'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
            'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
            'labels'             => [
                'form_terms'                                 => get_field('form_terms', $this->ID) ?: '',
                'form_section_label_general'                 => __('Register Volunteer Assignment',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_description_general'           => '',
                'field_label_general_title'                  => __('Name of the assignment',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_assignment_image'               => __('Assignment Image',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_general_contact_name'           => __('Your name (not publicly visible)',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_helper_general_contact_name'          => __(
                    'Only used by us for contact purposes',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ),
                'field_label_general_organisation'           => __('Name of organisation',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_general_contact_email'          => __('E-mail (not publicly visible)',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_placeholder_general_contact_email'    => __('example@email.com',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_helper_general_contact_email'         => __(
                    'Only used by us for contact purposes',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ),
                'field_label_general_contact_phone'          => __('Phone (not publicly visible)',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_placeholder_general_contact_phone'    => __('042-XX XX XX',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_helper_general_contact_phone'         => __(
                    'Only used by us for contact purposes',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ),
                'form_section_label_details'                 => __('Assignment information',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_description_details'           => '',
                'field_label_details_description'            => __('Description',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_details_benefits'               => __('Benefits',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_details_qualifications'         => __('Qualifications',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_details_when_and_where'         => __('When and where?',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_spots'                          => __('Total spots',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_assignment_location_address'    => __('Address',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_assignment_location_postal'     => __('Postal',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_label_assignment_location_city'       => __('City',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'form_section_label_signup'                  => __('Sign up information',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_description_signup'            => '',
                'field_option_label_signup_type_link'        => __('Sign up Link',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_option_label_signup_contact'          => __('Sign up Contact',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_option_label_signup_internal'         => __('Internal assignment',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_signup_signup_type'             => __('SignUp Type',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_signup_link'                    => __('Sign up link',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_placeholder_signup_link'              => __('https://www.website.com',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_option_label_signup_has_due_date_no'  => __('No', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_option_label_signup_has_due_date_yes' => __('Yes',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_signup_has_due_date'            => __('Is there a specific due date for signing up?',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_signup_due_date'                => __('Last date to apply',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_label_public_contact'          => __('Public Contact information',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_description_public_contact'    => '',
                'field_label_public_contact_email'           => __('Public E-Mail',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_placeholder_public_contact_email'     => __('example@email.com',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_public_contact_phone'           => __('Public Phone',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_placeholder_public_contact_phone'     => __('042-XX XX XX',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_label_employer'                => __('Employer information',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'form_section_description_employer'          => '',
                'field_label_employer_about'                 => __('About the employer',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'field_label_employer_website'               => __('Website',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).$optionalFieldLabel,
                'field_placeholder_employer_website'         => __('https://www.website.com',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'select_placeholder'                         => __('Select an option',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'submit_button_text'                         => __('Submit',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'error_text'                                 => __('Something went wrong, please try again later.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'success_text'                               => __('Successfully submitted new assignment!',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'loading_text'                               => __('Loading...',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'saving_text'                                => __('Saving...',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            ],
        ];
    }

    public function template(): string
    {
        return 'assignment-form.blade.php';
    }

    public function script()
    {
        if ( ! $this->hasModule()) {
            return;
        }

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