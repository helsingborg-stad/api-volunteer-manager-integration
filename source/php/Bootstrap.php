<?php

namespace APIVolunteerManagerIntegration;

class Bootstrap
{
    public function setBladeTemplatePaths(array $paths): array
    {
        array_unshift($paths, API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/views/');

        return $paths;
    }

    public function bootstrap(): void
    {
        add_filter('Municipio/blade/view_paths', [$this, 'setBladeTemplatePaths'], 5);
    }
}