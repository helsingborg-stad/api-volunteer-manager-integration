<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Services\WpRest\ClientClientFactory;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClientFactory;
use APIVolunteerManagerIntegration\Virtual\Routes;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\GlobalContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContextFactory;

class App
{
    private VQContextFactory $contextFactory;
    private WpRestClientFactory $wpRestClientFactory;

    public function __construct(
        ?VQContextFactory $contextFactory = null,
        ?WpRestClientFactory $wpRestClientFactory = null,
        ?HttpClientFactory $httpClientFactory = null
    ) {
        $this->contextFactory      = $contextFactory ?? new GlobalContextFactory();
        $this->wpRestClientFactory = $wpRestClientFactory ?? new ClientClientFactory($httpClientFactory);
    }

    public function init()
    {
        $this->bootstrap();
        $this->vq();
    }

    public function bootstrap()
    {
        (new Bootstrap())->bootstrap();
    }

    public function vq()
    {
        $virtualQuery = new Routes($this->wpRestClientFactory->createClient());
        $virtualQuery->init($this->contextFactory);
    }
}
