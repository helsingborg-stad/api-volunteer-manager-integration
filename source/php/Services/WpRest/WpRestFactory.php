<?php

namespace APIVolunteerManagerIntegration\Services\WpRest;

use APIVolunteerManagerIntegration\Helper\HttpClient\CurlClientFactory;
use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetOption;
use APIVolunteerManagerIntegration\Services\WpRest\Local\LocalWpRestClient;
use APIVolunteerManagerIntegration\Services\WpRest\Remote\RemoteWpRestClient;

class WpRestFactory implements WpRestClientFactory
{
    private HttpClientFactory $httpClientFactory;
    private ACFGetOption $acf;

    public function __construct(ACFGetOption $acf, ?HttpClientFactory $httpClientFactory = null)
    {
        $this->httpClientFactory = $httpClientFactory ?? new CurlClientFactory();
        $this->acf               = $acf;
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
                $this->acf->getOption('volunteer_manager_integration_api_uri') ?? '',
                $this->httpClientFactory
            );

        return $createClient();
    }

    public function useLocalWpRestClient(): bool
    {
        return file_exists(API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'local.json');
    }
}