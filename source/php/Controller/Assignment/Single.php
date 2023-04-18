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

        $data['volunteerAssignment'] = $model;
        $data['rightColumnSize']     = 4;


        return $data;
    }

    function getModel(?WP_Query $wpQuery): ?VolunteerAssignment
    {
        return $wpQuery && isset($wpQuery->post->model) && $wpQuery->post->model instanceof VolunteerAssignment
            ? $wpQuery->post->model
            : null;
    }
}