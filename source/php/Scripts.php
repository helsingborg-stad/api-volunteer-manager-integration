<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Helper\CacheBust;
use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\Services\WPService\GetPostType;
use APIVolunteerManagerIntegration\Services\WPService\WpEnqueueStyle;

class Scripts implements ActionHookSubscriber
{
    protected GetPostType $wp;
    protected WpEnqueueStyle $script;

    public function __construct(GetPostType $wp, WpEnqueueStyle $script)
    {
        $this->wp     = $wp;
        $this->script = $script;
    }

    public static function addActions()
    {
        return [['wp_enqueue_scripts', 'scripts', 20]];
    }

    public function scripts(): void
    {
        $this->script->wpEnqueueStyle(
            'api-volunteer-manager-integration-css',
            API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/'.CacheBust::name('css/api-volunteer-manager-integration.css'),
        );
    }
}
