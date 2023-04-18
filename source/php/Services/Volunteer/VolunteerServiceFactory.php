<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;

class VolunteerServiceFactory
{
    static function createFromWpRestClient(WpRestClient $wpRestClient): VolunteerService
    {
        return new class($wpRestClient) implements VolunteerService {
            private WpRestClient $wpRestClient;

            public function __construct(WpRestClient $wpRestClient)
            {
                $this->wpRestClient = $wpRestClient;
            }

            function assignments(): AssignmentService
            {
                return new AssignmentService($this->wpRestClient, AssignmentService::TYPE);
            }

            function toArray(): array
            {
                return [
                    AssignmentService::class => $this->assignments(),
                ];
            }
        };
    }
}