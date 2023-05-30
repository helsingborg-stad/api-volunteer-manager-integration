<?php

namespace APIVolunteerManagerIntegration\Services\ModularityService;

use function modularity_register_module;

class ModularityFunctions implements ModularityRegisterModule
{
    function modularityRegisterModule(string $path, string $className): void
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (function_exists('\modularity_register_module')) {
            modularity_register_module($path, $className);
        }
    }
}