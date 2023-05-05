<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function register_nav_menu().
 */
interface RegisterNavMenu
{
    /**
     * Registers a new navigation menu.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menu/
     *
     * @param  string|list<string>  $location  The location or locations on the theme where the menu will be displayed.
     * @param  string  $description  A description of the menu.
     *
     * @return void
     */
    public function registerNavMenu($location, string $description): void;
}
