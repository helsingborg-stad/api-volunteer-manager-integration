<?php


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group([
        'key'                   => 'group_644ad1b3d7072',
        'title'                 => __('Volunteer Manager Integration Settings', 'api-volunteer-manager-integration'),
        'fields'                => [
            0 => [
                'key'               => 'field_64a43f780f61f',
                'label'             => __('API Configuration', 'api-volunteer-manager-integration'),
                'name'              => '',
                'aria-label'        => '',
                'type'              => 'accordion',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'open'              => 0,
                'multi_expand'      => 0,
                'endpoint'          => 0,
            ],
            1 => [
                'key'               => 'field_644ad20162939',
                'label'             => __('API URL', 'api-volunteer-manager-integration'),
                'name'              => 'volunteer_manager_integration_api_uri',
                'aria-label'        => '',
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
            2 => [
                'key'               => 'field_646773091abc7',
                'label'             => __('App Secret', 'api-volunteer-manager-integration'),
                'name'              => 'volunteer_manager_integration_app_secret',
                'aria-label'        => '',
                'type'              => 'text',
                'instructions'      => __('base64encoded string "clientid:clientsecret"',
                    'api-volunteer-manager-integration'),
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'default_value'     => '',
                'maxlength'         => '',
                'placeholder'       => '',
                'prepend'           => '',
                'append'            => '',
            ],
            3 => [
                'key'               => 'field_65045f9f5dca2',
                'label'             => __('Cron', 'api-volunteer-manager-integration'),
                'name'              => '',
                'aria-label'        => '',
                'type'              => 'accordion',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'open'              => 0,
                'multi_expand'      => 0,
                'endpoint'          => 0,
            ],
            4 => [
                'key'               => 'field_65045eeee86f5',
                'label'             => __('Daily Import', 'api-volunteer-manager-integration'),
                'name'              => 'volunteer_assignments_daily_import',
                'aria-label'        => '',
                'type'              => 'true_false',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'message'           => '',
                'default_value'     => 0,
                'ui_on_text'        => __('Enabled', 'api-volunteer-manager-integration'),
                'ui_off_text'       => __('Disabled', 'api-volunteer-manager-integration'),
                'ui'                => 1,
            ],
            5 => [
                'key'               => 'field_64a43f9f0f620',
                'label'             => __('Volunteer', 'api-volunteer-manager-integration'),
                'name'              => '',
                'aria-label'        => '',
                'type'              => 'accordion',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'open'              => 1,
                'multi_expand'      => 0,
                'endpoint'          => 0,
            ],
            6 => [
                'key'               => 'field_64a43d5b32c31',
                'label'             => __('Registration Page', 'api-volunteer-manager-integration'),
                'name'              => 'volunteer_manager_integration_volunteer_registration_page',
                'aria-label'        => '',
                'type'              => 'link',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => [
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ],
                'return_format'     => 'array',
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
        'instruction_placement' => 'field',
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