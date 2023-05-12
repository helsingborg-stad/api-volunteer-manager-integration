<?php


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group([
        'key'                   => 'group_644ad1b3d7072',
        'title'                 => __('Volunteer Manager Integration Settings', 'api-volunteer-manager-integration'),
        'fields'                => [
            0 => [
                'key'               => 'field_644ad20162939',
                'label'             => __('API URL', 'api-volunteer-manager-integration'),
                'name'              => 'volunteer_manager_integration_api_uri',
                'type'              => 'url',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'default_value'     => '',
                'placeholder'       => '',
            ],
        ],
        'location'              => [
            0 => [
                0 => [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'volunteer-integration-settings',
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