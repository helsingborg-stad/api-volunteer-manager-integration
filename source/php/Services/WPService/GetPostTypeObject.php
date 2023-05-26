<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

use WP_Post_Type;

/**
 * Interface for the WordPress function get_post_type_object().
 *
 * @link https://developer.wordpress.org/reference/functions/get_post_type_object/
 */
interface GetPostTypeObject
{
    /**
     * Retrieves the post type object for a given post type.
     *
     * @param  string  $postType  The post type.
     *
     * @return WP_Post_Type|null The post type object, or null if the post type does not exist.
     */
    public function getPostTypeObject(string $postType): ?WP_Post_Type;
}
