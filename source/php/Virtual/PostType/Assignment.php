<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType;


use APIVolunteerManagerIntegration\Services\Volunteer\AssignmentService;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Archive;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Single;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntity;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQFromSource;

class Assignment implements VQEntity
{
    const POST_TYPE = 'volunteer-assignment';

    function registerEntity(VQFromSource $virtualQuery): VQFromSource
    {
        $virtualQuery
            ->fromSource(AssignmentService::class)
            ->toPostType(self::POST_TYPE)
            ->withSlug('volontaruppdrag')
            ->withLabel(__('Volunteer Assignment', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN))
            ->withController(new Single())
            ->withController(new Archive());

        return $virtualQuery;
    }
}