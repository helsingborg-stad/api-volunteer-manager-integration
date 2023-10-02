<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;
use APIVolunteerManagerIntegration\Services\ACFService\ACFService;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use Municipio\Helper\Post;

class SignUpModal
{
    private MyPages $myPages;
    private ACFService $acf;

    public function __construct(MyPages $myPages, ACFService $acf)
    {
        $this->myPages = $myPages;
        $this->acf     = $acf;
    }

    public function data(): array
    {
        $post = get_queried_object();

        if (empty(WP::getPostMeta('internal_assignment'))
            || empty($_GET['sign_up'])
            || (int) $_GET['sign_up'] !== (int) WP::getPostMeta('uuid')) {
            return [];
        }

        return [
            'heading'            => __('Volunteer login', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'closeButtonText'    => __('Close', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'assignment'         => (object) [
                'title'    => get_the_title(),
                'employer' => WP::getPostMeta('employer_name', null),
                'image'    => Post::getFeaturedImage(get_queried_object_id(), 'large'),
            ],
            'id'                 => 'assignment-sign-up-modal-'.(string) ($post->ID ?? ''),
            'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
            'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
            'labels'             => [
                'after_sign_up_text'            => __('Thank you for showing interest, we will get back to you as soon as possible.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'sign_up_button_label'          => __('Apply to assignment',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'logout_button_label'           => __('Logout',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'volunteer_not_approved_text'   => __('Your volunteer application is pending, please try again later.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'volunteer_not_registered_text' => __('You are not a registered volunteer, please register an account.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'loading_text'                  => __('Loading',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'saving_text'                   => __('Saving',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'error_text'                    => __('Something went wrong, please try again later.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'volunteer_name_field_label'    => __('Volunteer',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'employer_name_field_label'     => __('Employer',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'logged_in_as'                  => __('Logged in as',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'registration_button_label'     => __('Volunteer registration',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            ],
            'signOutUrl'         => $this->myPages->signOutUrl(),
            'registrationUrl'    => $this->acf->getField('volunteer_manager_integration_volunteer_registration_page',
                    'options')['url'] ?? '#',
        ];
    }
}