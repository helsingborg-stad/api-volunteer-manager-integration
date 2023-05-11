<?php

namespace APIVolunteerManagerIntegration\Admin;


use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
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
            'menu_title'  => __('Volunteer Integration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'menu_slug'   => 'volunteer-integration-settings',
            'parent_slug' => 'options-general.php',
            'capability'  => 'manage_options',
        ]);
    }
}
