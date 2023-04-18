<?php

namespace APIVolunteerManagerIntegration\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;

class Archive extends VQArchiveController
{
    public string $postType = '';

    function archive(array $data): array
    {
        $data['posts'] = array_map([$this, 'mapThumbnails'], $data['posts']);

        return $data;
    }

    function mapThumbnails(object $post): object
    {
        $model = $this->getModelFromPost($post);
        if ($model->featuredImage) {
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