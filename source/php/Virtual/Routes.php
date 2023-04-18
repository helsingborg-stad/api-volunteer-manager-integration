<?php

namespace APIVolunteerManagerIntegration\Virtual;


use APIVolunteerManagerIntegration\Services\Volunteer\VolunteerServiceFactory;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\VirtualQueryApp;

class Routes extends VirtualQueryApp
{
    private WpRestClient $wpRestClient;

    public function __construct(WpRestClient $wpRestClient)
    {
        $this->wpRestClient = $wpRestClient;
    }

    function entities(): array
    {
        return [
            new Assignment(),
        ];
    }

    function source(): array
    {
        return VolunteerServiceFactory
            ::createFromWpRestClient($this->wpRestClient)
            ->toArray();
    }
}