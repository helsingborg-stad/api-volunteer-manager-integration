<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function get_post_type_archive_link().
 *
 * @link https://developer.wordpress.org/reference/functions/get_post_type_archive_link/
 */
interface GetPostTypeArchiveLink
{
    /**
     * Retrieves the permalink for the archive page of a specific post type.
     *
     * @param  string  $postType  The post type.
     *
     * @return string|false The archive page permalink for the post type, or false on failure.
     */
    public function getPostTypeArchiveLink(string $postType);
}
