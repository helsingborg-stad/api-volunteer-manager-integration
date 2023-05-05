<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function is_single().
 */
interface IsSingle
{
    /**
     * Determines whether the current page is a single post page.
     * @link https://developer.wordpress.org/reference/functions/is_single/
     *
     * @return bool True if the current page is a single post page, false otherwise.
     */
    public function isSingle(): bool;
}
