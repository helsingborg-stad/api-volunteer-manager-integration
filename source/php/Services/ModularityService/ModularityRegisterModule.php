<?php

namespace APIVolunteerManagerIntegration\Services\ModularityService;

interface ModularityRegisterModule
{
    function modularityRegisterModule(string $path, string $className): void;
}