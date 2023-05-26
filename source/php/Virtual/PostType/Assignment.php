<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType;


use APIVolunteerManagerIntegration\Services\Volunteer\AssignmentService;
use APIVolunteerManagerIntegration\Services\WPService\WPService;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Archive;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Single;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntity;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQFromSource;

class Assignment implements VQEntity
{
    const POST_TYPE = 'volunteer-assignment';
    private WPService $wp;

    public function __construct(WPService $wp)
    {
        $this->wp = $wp;
    }

    function registerEntity(VQFromSource $virtualQuery): VQFromSource
    {
        $virtualQuery
            ->fromSource(AssignmentService::class)
            ->toPostType(self::POST_TYPE)
            ->withSlug('volontaruppdrag')
            ->withLabel(__('Volunteer Assignment', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN))
            ->withController(new Single($this->wp, $this->wp, $this->wp,))
            ->withController(new Archive($this->wp, $this->wp, $this->wp));

        return $virtualQuery;
    }
}