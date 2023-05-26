<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainer;
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;
use APIVolunteerManagerIntegration\Virtual\Routes;

class App
{
    public function init(DIContainer $DI, PluginManager $plugin)
    {
        (new Bootstrap())
            ->bootstrap($DI, $plugin);

        $plugin
            ->register($DI->make(Routes::class))
            ->register($DI->make(OptionsPage::class));
    }
}
