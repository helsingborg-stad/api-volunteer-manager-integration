<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function get_nav_menu_locations().
 */
interface GetNavMenuLocations
{
    /**
     * Retrieves the registered nav menu locations.
     * @link https://developer.wordpress.org/reference/functions/get_nav_menu_locations/
     *
     * @return array The registered nav menu locations.
     */
    public function getNavMenuLocations(): array;
}
