<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;
use WP_Query;

class Archive extends VQArchiveController
{
    public string $postType = '';

    function archive(array $data): array
    {
        $data['posts'] = array_map([$this, 'mapThumbnails'], $data['posts']);

        $data['breadcrumbItems'] = $this->breadcrumbs($data['wpQuery'] ?? null);

        return $data;
    }

    private function breadcrumbs(?WP_Query $wpQuery = null): array
    {
        return $wpQuery ? [
            [
                'label'   => __('Home', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'href'    => home_url(),
                'current' => false,
                'icon'    => 'home',
            ],
            [
                'label'   => get_post_type_object($wpQuery->get('post_type'))->label ?? '',
                'href'    => get_post_type_archive_link($wpQuery->get('post_type')),
                'current' => true,
                'icon'    => 'chevron_right',
            ],
        ] : [];
    }

    function mapThumbnails(object $post): object
    {
        $model = $this->getModelFromPost($post);
        if ($model && $model->featuredImage) {
            $post->thumbnail = [
                'src'   => $model->featuredImage->source,
                'alt'   => $model->featuredImage->altText,
                'title' => $model->featuredImage->fileName,
            ];
        }

        return $post;
    }

    function getModelFromPost(object $post): ?VolunteerAssignment
    {
        return isset($post->model) && $post->model instanceof VolunteerAssignment
            ? $post->model
            : null;
    }
}