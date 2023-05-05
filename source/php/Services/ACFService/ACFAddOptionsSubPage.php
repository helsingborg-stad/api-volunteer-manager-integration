<?php

namespace APIVolunteerManagerIntegration\Services\ACFService;

interface ACFAddOptionsSubPage
{
    /**
     * ACF function: acf_add_options_sub_page
     * @link https://www.advancedcustomfields.com/resources/acf_add_options_sub_page/
     *
     * @param  array|null  $settings
     *
     * @return void
     */
    public function acfAddOPtionsSubPage(?array $settings = []);
}
