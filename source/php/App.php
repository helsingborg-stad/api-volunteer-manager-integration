<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainer;
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\Routes;

class App
{
    public function init(DIContainer $DI)
    {
        (new Bootstrap())->bootstrap($DI);
        $this->registerHooks($DI, $DI->resolve(PluginManager::class));
    }

    public function registerHooks(DIContainer $DI, PluginManager $plugin)
    {
        new Import\Setup();
        new PostTypes\Assignment();

        $plugin
            ->register($DI->make(Routes::class)) //Deprecated
            ->register($DI->make(OptionsPage::class))
            ->register($DI->make(Scripts::class))
            ->register($DI->make(Assignment\Scripts::class)) //Deprecated
            ->register($DI->make(Assignment\PreventAlgolia::class)) //Deprecated
            ->register($DI->make(Assignment\PreventRobots::class)) //Deprecated
            ->register($DI->make(PostTypes\Assignment\Scripts::class))
            ->register($DI->make(PostTypes\Assignment\PreventAlgolia::class))
            ->register($DI->make(PostTypes\Assignment\PreventRobots::class))
            ->register($DI->make(Controller\Assignment\Single::class));
    }
}
