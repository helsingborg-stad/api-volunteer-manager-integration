<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function wp_get_nav_menu_items().
 */
interface WpGetNavMenuItems
{
    /**
     * Retrieves the menu items for a given nav menu.
     * @link https://developer.wordpress.org/reference/functions/wp_get_nav_menu_items/
     *
     * @param  string|int  $menu  The menu ID, slug, name, or term ID to retrieve the items for.
     * @param  array  $args  Optional. Array of arguments to customize the retrieved menu items.
     *
     * @return array|null Array of menu items, or false if the menu doesn't exist or has no items.
     */
    public function wpGetNavMenuItems($menu, $args = []): ?array;
}
