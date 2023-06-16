<?php

namespace APIVolunteerManagerIntegration\Virtual;


use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use APIVolunteerManagerIntegration\Services\Volunteer\VolunteerServiceFactory;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClientFactory;
use APIVolunteerManagerIntegration\Services\WPService\WPService;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\VirtualQueryApp;

class Routes extends VirtualQueryApp implements ActionHookSubscriber
{
    private WpRestClientFactory $wpRestClientFactory;
    private VQContextFactory $contextFactory;
    private WPService $wp;
    private MyPages $myPages;

    public function __construct(
        WpRestClientFactory $wpRestClientFactory,
        VQContextFactory $contextFactory,
        WPService $wp,
        MyPages $myPages
    ) {
        $this->wpRestClientFactory = $wpRestClientFactory;
        $this->contextFactory      = $contextFactory;
        $this->wp                  = $wp;
        $this->myPages             = $myPages;
    }

    public static function addActions(): array
    {
        return [
            [
                'acf/init', 'initialize', 10, 0,
            ],
        ];
    }

    function entities(): array
    {
        return [
            new Assignment($this->wp, $this->myPages),
        ];
    }

    function source(): array
    {
        return VolunteerServiceFactory
            ::createFromWpRestClient($this->wpRestClientFactory->createClient())
            ->toArray();
    }

    function initialize(): void
    {
        $this->init($this->contextFactory);
    }
}