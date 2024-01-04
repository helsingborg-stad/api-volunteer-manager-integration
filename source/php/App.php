<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainer;
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;

class App
{
    public function init(DIContainer $DI)
    {
        (new Bootstrap())->bootstrap($DI);
        $this->registerHooks($DI, $DI->resolve(PluginManager::class));
    }

    public function registerHooks(DIContainer $DI, PluginManager $plugin)
    {
        $plugin
            ->register($DI->make(OptionsPage::class))
            ->register($DI->make(Scripts::class))
            ->register($DI->make(Import\Setup::class))
            ->register($DI->make(PostTypes\Assignment::class))
            ->register($DI->make(PostTypes\Assignment\Scripts::class))
            ->register($DI->make(PostTypes\Assignment\PreventAlgolia::class))
            ->register($DI->make(PostTypes\Assignment\PreventRobots::class))
            ->register($DI->make(PostTypes\Assignment\OverridePostTypeSlug::class))
            ->register($DI->make(PostTypes\Assignment\Controller\Single::class));
    }
}
