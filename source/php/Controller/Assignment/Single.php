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
}