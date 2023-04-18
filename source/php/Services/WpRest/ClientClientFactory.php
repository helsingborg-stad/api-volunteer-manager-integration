<?php

namespace APIVolunteerManagerIntegration\Services\WpRest;

use APIVolunteerManagerIntegration\Helper\HttpClient\CurlClientFactory;
use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Services\WpRest\Local\LocalWpRestClient;
use APIVolunteerManagerIntegration\Services\WpRest\Remote\RemoteWpRestClient;

class ClientClientFactory implements WpRestClientFactory
{
    private HttpClientFactory $httpClientFactory;

    public function __construct(?HttpClientFactory $httpClientFactory = null)
    {
        $this->httpClientFactory = $httpClientFactory ?? new CurlClientFactory();
    }

    function createClient(): WpRestClient
    {
        $createClient = $this->useLocalWpRestClient()
            ? fn(): WpRestClient => LocalWpRestClient::createFromJson(
                file_get_contents(
                    API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'local.json'
                )
            )
            : fn(): WpRestClient => new RemoteWpRestClient(
                'https://modul-test.helsingborg.io/volontar/json',
                $this->httpClientFactory
            );

        return $createClient();
    }

    public function useLocalWpRestClient(): bool
    {
        return file_exists(API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'local.json');
    }
}