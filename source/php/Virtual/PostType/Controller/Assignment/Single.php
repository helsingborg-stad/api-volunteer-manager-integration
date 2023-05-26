<?php
declare(strict_types=1);

namespace APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
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

        $data['rightColumnSize']     = 4;
        $data['featuredImage']       = $this->featuredImage($model);
        $data['breadcrumbItems']     = $this->breadcrumbs($data['wpQuery']);
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
            'src'   => ! empty($model->featuredImage->source) ? $model->featuredImage->source : null,
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