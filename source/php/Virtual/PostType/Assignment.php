<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType;


use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Services\ACFService\ACFService;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
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
    private MyPages $myPages;
    private HttpClientFactory $httpClientFactory;
    private ACFService $acf;

    public function __construct(WPService $wp, MyPages $myPages, ACFService $acf)
    {
        $this->wp      = $wp;
        $this->myPages = $myPages;
        $this->acf     = $acf;
    }

    function registerEntity(VQFromSource $virtualQuery): VQFromSource
    {
        $virtualQuery
            ->fromSource(AssignmentService::class)
            ->toPostType(self::POST_TYPE)
            ->withSlug(defined('VOLUNTEER_MANAGER_INTEGRATION_ASSIGNMENT_SLUG') ? VOLUNTEER_MANAGER_INTEGRATION_ASSIGNMENT_SLUG : 'volontaruppdrag')
            ->withLabel(__('Volunteer Assignment', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN))
            ->withController(new Single(
                $this->wp,
                $this->wp,
                $this->wp,
                $this->myPages,
                $this->acf,
            ))
            ->withController(new Archive($this->wp, $this->wp, $this->wp));

        return $virtualQuery;
    }
}