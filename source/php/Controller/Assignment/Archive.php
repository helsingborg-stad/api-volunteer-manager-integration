<?php

namespace APIVolunteerManagerIntegration\Controller\Assignment;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;

class Archive extends VQArchiveController
{
    public string $postType = '';

    function archive(array $data): array
    {
        return $data;
    }
}