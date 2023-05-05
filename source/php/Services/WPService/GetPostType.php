<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function get_post_type().
 */
interface GetPostType
{
    /**
     * Gets the post type of a given post.
     * @link https://developer.wordpress.org/reference/functions/get_post_type/
     *
     * @param  int  $postId  Optional. Post ID. Default is the current post.
     *
     * @return string|null The post type of the given post or false if the post is not found.
     */
    public function getPostType(?int $postId = null): ?string;
}
