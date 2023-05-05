<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function is_archive().
 */
interface IsArchive
{
    /**
     * Determines whether the current page is an archive page.
     * @link https://developer.wordpress.org/reference/functions/is_archive/
     *
     * @return bool True if the current page is an archive page, false otherwise.
     */
    public function isArchive(): bool;
}
