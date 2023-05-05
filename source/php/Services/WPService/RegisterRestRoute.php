<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function register_rest_route().
 */
interface RegisterRestRoute
{
    /**
     * Registers a new REST API route.
     * @link https://developer.wordpress.org/reference/functions/register_rest_route/
     *
     * @param  string  $namespace  The namespace for the route.
     * @param  string  $route  The route for the endpoint, without the leading slash.
     * @param  array  $args  The arguments for the route.
     *
     * @return bool True if the route was registered successfully, false otherwise.
     */
    public function registerRestRoute(string $namespace, string $route, array $args): bool;
}
