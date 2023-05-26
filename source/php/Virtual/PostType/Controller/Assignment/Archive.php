<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeArchiveLink;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeObject;
use APIVolunteerManagerIntegration\Services\WPService\HomeUrl;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;
use WP_Query;

class Archive extends VQArchiveController
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

    function archive(array $data): array
    {
        $data['posts'] = array_map(
            [$this, 'mapThumbnails'],
            $data['posts']
        );

        $data['breadcrumbItems'] = $this->breadcrumbs($data['wpQuery']);

        return $data;
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
                'current' => true,
                'icon'    => 'chevron_right',
            ],
        ];
    }

    function mapThumbnails(object $post): object
    {
        $model           = $this->getModelFromPost($post);
        $post->thumbnail = $model && $model->featuredImage
            ? [
                'src'   => $model->featuredImage->source,
                'alt'   => $model->featuredImage->altText,
                'title' => $model->featuredImage->fileName,
            ]
            : [
                'src'   => null,
                'alt'   => null,
                'title' => $post->postTitle ?? $post->post_title ?? '',
            ];

        return $post;
    }

    function getModelFromPost(object $post): ?VolunteerAssignment
    {
        return isset($post->model) && $post->model instanceof VolunteerAssignment
            ? $post->model
            : null;
    }
}