<?php

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetField;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;

class LoginModal
{
    private ACFGetField $acf;
    private MyPages $myPages;

    public function __construct(
        MyPages $myPages,
        ACFGetField $acf
    ) {
        $this->myPages = $myPages;
        $this->acf     = $acf;
    }

    public function data(): array
    {
        if (empty(WP::getPostMeta('internal_assignment', null))) {
            return [];
        }

        return [
            'heading' => __('Volunteer login', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'id'      => 'assignment-modal-'.(string) (get_queried_object_id()),
            'buttons' => [
                [
                    'text'      => __('Volunteer login', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'href'      => $this->myPages->loginUrl(get_permalink().'?'.http_build_query(['sign_up' => WP::getPostMeta('uuid')])),
                    'color'     => 'primary',
                    'style'     => 'filled',
                    'fullWidth' => true,
                ],
                [
                    'text'      => __('Volunteer registration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'href'      => $this->acf->getField('volunteer_manager_integration_volunteer_registration_page',
                            'options')['url'] ?? '#',
                    'color'     => 'primary',
                    'style'     => 'basic',
                    'fullWidth' => true,
                ],
            ],
        ];
    }
}