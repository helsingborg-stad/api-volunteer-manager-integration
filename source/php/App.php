<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainer;
use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;
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

    public function init(DIContainer $DI, PluginManager $plugin)
    {
        (new Bootstrap())
            ->bootstrap($DI, $plugin);


        $plugin->register($this->vq())
               ->register($DI->make(OptionsPage::class));
    }

    public function vq(): Routes
    {
        $virtualQuery = new Routes($this->wpRestClientFactory->createClient());
        $virtualQuery->init($this->contextFactory);

        return $virtualQuery;
    }
}
