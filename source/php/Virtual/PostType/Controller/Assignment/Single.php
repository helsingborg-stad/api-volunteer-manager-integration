<?php
declare(strict_types=1);

namespace APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetField;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeArchiveLink;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeObject;
use APIVolunteerManagerIntegration\Services\WPService\HomeUrl;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQSingleController;
use WP_Query;

class Single extends VQSingleController
{
    public string $postType = '';
    private HomeUrl $homeUrl;
    private GetPostTypeObject $getPostTypeObject;
    private GetPostTypeArchiveLink $getPostTypeArchiveLink;
    private ACFGetField $acf;

    public function __construct(
        HomeUrl $homeUrl,
        GetPostTypeObject $getPostTypeObject,
        GetPostTypeArchiveLink $getPostTypeArchiveLink
    ) {
        $this->homeUrl                = $homeUrl;
        $this->getPostTypeObject      = $getPostTypeObject;
        $this->getPostTypeArchiveLink = $getPostTypeArchiveLink;
    }

    function single(array $data): array
    {
        $model = $this->getModel($data['wpQuery']);

        if ( ! $model) {
            $data['volunteerAssignment'] = null;

            return $data;
        }

        $data['rightColumnSize']   = 5;
        $data['featuredThumbnail'] = $this->featuredImage($model);
        $data['breadcrumbItems']   = $this->breadcrumbs($data['wpQuery']);

        $data['volunteerAssignmentLabels'] = [
            'about'          => __(
                'Information about the assignment',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'benefits'       => __(
                'Information about the assignment',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'requirements'   => __(
                'Information about the assignment',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'where_and_when' => __(
                'Information about the assignment',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'sign_up'        => __(
                'Sign up',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'sign_up_c2a'    => __(
                'Sign up',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'contact_us'     => __(
                'Contact',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
        ];

        $data['volunteerAssignment'] = $model;


        return $data;
    }

    function getModel(?WP_Query $wpQuery): ?VolunteerAssignment
    {
        return $wpQuery && isset($wpQuery->post->model) && $wpQuery->post->model instanceof VolunteerAssignment
            ? $wpQuery->post->model
            : null;
    }

    function featuredImage(VolunteerAssignment $model): object
    {
        return (object) [
            'id'    => $model->featuredImage->id ?? 0,
            'src'   => ! empty($model->featuredImage->source) ? [$model->featuredImage->source] : [],
            'alt'   => $model->featuredImage->altText ?? '',
            'title' => $model->featuredImage->fileName ?? '',
        ];
    }

    private function breadcrumbs(WP_Query $wpQuery): array
    {
        return [
            [
                'label'   => __('Home', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'href'    => $this->homeUrl->homeUrl(),
                'current' => false,
                'icon'    => 'home',
            ],
            [
                'label'   => $this->getPostTypeObject->getPostTypeObject($wpQuery->get('post_type'))->label ?? '',
                'href'    => $this->getPostTypeArchiveLink->getPostTypeArchiveLink($wpQuery->get('post_type')),
                'current' => false,
                'icon'    => 'chevron_right',
            ],
            [
                'label'   => $wpQuery->post->post_title ?? $wpQuery->get('name'),
                'href'    => $this->getPostTypeArchiveLink->getPostTypeArchiveLink($wpQuery->get('post_type')).$wpQuery->get('name').'/',
                'current' => true,
                'icon'    => 'chevron_right',
            ],
        ];
    }
}