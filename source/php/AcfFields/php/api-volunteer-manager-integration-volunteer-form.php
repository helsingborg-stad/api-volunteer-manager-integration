<?php


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group([
        'key'                   => 'group_64abbfd89cb56',
        'title'                 => __('Volunteer Form Module', 'api-volunteer-manager-integration'),
        'fields'                => [
            0 => [
                'key'               => 'field_64abbfd8a06b8',
                'label'             => __('Form Terms', 'api-volunteer-manager-integration'),
                'name'              => 'form_terms',
                'aria-label'        => '',
                'type'              => 'wysiwyg',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'default_value'     => '',
                'tabs'              => 'all',
                'toolbar'           => 'basic',
                'media_upload'      => 0,
                'delay'             => 1,
            ],
        ],
        'location'              => [
            0 => [
                0 => [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'mod-volunteer-form',
                ],
            ],
            1 => [
                0 => [
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/volunteer-form',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
        'acfe_display_title'    => '',
        'acfe_autosync'         => '',
        'acfe_form'             => 0,
        'acfe_meta'             => '',
        'acfe_note'             => '',
    ]);

}