<?php

namespace APIVolunteerManagerIntegration\Services\ACFService;

class ACFServiceFactory
{
    public static function create(): ACFService
    {
        return new class implements ACFService {
            public function getField(string $selector, $postId)
            {
                return get_field($selector, $postId);
            }

            public function getOption(string $selector)
            {
                return get_field($selector, 'options');
            }

            public function acfAddOptionsSubPage(?array $settings = [])
            {
                if (function_exists('acf_add_options_sub_page')) {
                    acf_add_options_sub_page($settings);
                }
            }
        };
    }
}
