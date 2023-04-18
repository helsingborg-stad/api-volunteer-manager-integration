<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType;

use WP_Post;

class VirtualPostFactory
{
    public static function create(array $args): WP_Post
    {
        return new WP_Post((object) [
            'ID'                => $args['id'] ?? 0,
            'post_title'        => $args['title'] ?? '',
            'post_name'         => $args['slug'] ?? '',
            'post_content'      => $args['content'] ?? '',
            'post_excerpt'      => $args['content'] ?? '',
            'post_parent'       => 0,
            'menu_order'        => 0,
            'post_type'         => $args['type'] ?? '',
            'post_status'       => $args['status'] ?? 'publish',
            'comment_status'    => 'closed',
            'ping_status'       => 'closed',
            'comment_count'     => 0,
            'post_password'     => '',
            'to_ping'           => '',
            'pinged'            => '',
            'guid'              => '',
            'post_date'         => $args['created'] ?? '',
            'post_date_gmt'     => $args['created'] ?? '',
            'post_modified'     => $args['modified'] ?? '',
            'post_modified_gmt' => $args['modified'] ?? '',
            'post_author'       => 0,
            'is_virtual'        => true,
            'filter'            => 'raw',
            'post_meta'         => $args['meta'] ?? [],
            'model'             => $args['model'] ?? [],
        ]);
    }
}