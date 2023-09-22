<?php

namespace APIVolunteerManagerIntegration\Admin;

use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\PostTypes;
use APIVolunteerManagerIntegration\Services\ACFService\ACFAddOptionsSubPage;

class OptionsPage implements ActionHookSubscriber
{
    private ACFAddOptionsSubPage $acf;

    public function __construct(ACFAddOptionsSubPage $acf)
    {
        $this->acf = $acf;
    }

    public static function addActions(): array
    {
        return [['init', 'registerOptionsPage', 5]];
    }

    public function registerOptionsPage(): void
    {
        $this->acf->acfAddOPtionsSubPage([
            'page_title'  => __('Volunteer Integration settings', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'menu_title'  => __('Settings', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'menu_slug'   => 'volunteer-integration-settings',
            'parent_slug' => 'edit.php?post_type='.PostTypes\Assignment::$postType,
            'capability'  => 'manage_options',
        ]);
    }
}
