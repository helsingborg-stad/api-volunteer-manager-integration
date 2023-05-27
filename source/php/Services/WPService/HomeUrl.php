<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function home_url().
 */
interface HomeUrl
{
    /**
     * Retrieves the home URL for the current site.
     * @link https://developer.wordpress.org/reference/functions/home_url/
     *
     * @param  string  $path  Optional. Path relative to the home URL.
     * @param  string|null  $scheme  Optional. The scheme to use for the URL (http or https). Default is the scheme
     *     used to. Load the site.
     *
     * @return string The home URL for the current site.
     */
    public function homeUrl(string $path = '', string $scheme = null): string;
}
