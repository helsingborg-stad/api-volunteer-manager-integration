<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Assignment;

use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\Services\AssetsService\AssetsService;
use APIVolunteerManagerIntegration\Services\WPService\GetPostType;
use APIVolunteerManagerIntegration\Services\WPService\WpEnqueueScript;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;

class Scripts implements ActionHookSubscriber
{
    protected GetPostType $wp;
    protected WpEnqueueScript $script;
    private AssetsService $assets;

    public function __construct(GetPostType $wp, WpEnqueueScript $script, AssetsService $assets)
    {
        $this->wp     = $wp;
        $this->script = $script;
        $this->assets = $assets;
    }

    public static function addActions()
    {
        return [['wp_enqueue_scripts', 'scripts', 20]];
    }

    public function scripts(): void
    {
        if ($this->wp->getPostType() === Assignment::POST_TYPE) {
            $this->script->wpEnqueueScript(
                'sign-up-js',
                $this->assets->getAssetUrl('js/sign-up.js'),
                ['gdi-host', 'mod-my-pages-js']
            );
        }
    }
}
