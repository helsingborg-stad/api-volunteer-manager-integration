<?php
declare(strict_types=1);

namespace APIVolunteerManagerIntegration\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQSingleController;
use WP_Query;

class Single extends VQSingleController
{
    public string $postType = '';

    function single(array $data): array
    {
        $model = $this->getModel($data['wpQuery']);

        if ( ! $model) {
            $data['volunteerAssignment'] = null;

            return $data;
        }

        $data['rightColumnSize']     = 4;
        $data['featuredImage']       = $this->featuredImage($model);
        $data['breadcrumbItems']     = $this->breadcrumbs($data['wpQuery'] ?? null);
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
            'src'   => ! empty($model->featuredImage->source) ? [
                $model->featuredImage->source,
            ] : [],
            'alt'   => $model->featuredImage->altText ?? '',
            'title' => $model->featuredImage->fileName ?? '',
        ];
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
                'current' => false,
                'icon'    => 'chevron_right',
            ],
            [
                'label'   => $wpQuery->post->post_title ?? $wpQuery->get('name'),
                'href'    => get_post_type_archive_link($wpQuery->get('post_type')).$wpQuery->get('name').'/',
                'current' => true,
                'icon'    => 'chevron_right',
            ],
        ] : [];
    }
}