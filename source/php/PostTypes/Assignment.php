<?php

namespace APIVolunteerManagerIntegration\PostTypes;

use APIVolunteerManagerIntegration\Helper\PostType;

class Assignment
{
    public static $postType = 'vol-assignment';

    public function __construct()
    {
        add_action('init', [$this, 'registerPostType'], 9);
    }

    public function registerPostType()
    {
        $customPostType = new PostType(
            self::$postType,
            __('Volunteer Assignment', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            __('Volunteer Assignments', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            [
                'menu_icon'          => 'dashicons-heart',
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'supports'           => ['title', 'editor', 'thumbnail'],
                'show_in_rest'       => true,
                'menu_position'      => 30,
            ],
            [],
            ['exclude_keys' => ['author', 'acf', 'guid', 'link', 'template', 'meta', 'taxonomy', 'menu_order']]
        );

        foreach (self::taxonomies() as $taxonomy) {
            $customPostType->addTaxonomy(
                $taxonomy['slug'],
                $taxonomy['singular'],
                $taxonomy['plural'],
                $taxonomy['args'],
            );
        }
    }

    private static function taxonomies()
    {
        return [
            [
                'slug'     => 'volunteer_assignment_category',
                'singular' => __('Category', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'plural'   => __('Categories', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'args'     => ['hierarchical' => false, 'show_ui' => false],
            ],
        ];
    }
}
