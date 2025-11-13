<?php

namespace APIVolunteerManagerIntegration\Tests\Admin;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\PostTypes;
use APIVolunteerManagerIntegration\Services\ACFService\ACFAddOptionsSubPage;
use APIVolunteerManagerIntegration\Tests\_TestUtils\PluginTestCase;
use function __;


class OptionsPageTest extends PluginTestCase
{
    public function testRegisterAddsActionHooksCorrectly(): void
    {
        $acfMock     = $this->createMock(ACFAddOptionsSubPage::class);
        $optionsPage = new OptionsPage($acfMock);


        $this->wp
            ->addAction(
                'init',
                [$optionsPage, 'registerOptionsPage'],
                5,
                1)
            ->shouldBeCalled();

        $this->pluginManager->register($optionsPage);
    }

    public function testRegisterOptionsPage()
    {
        $acfMock = $this->createMock(ACFAddOptionsSubPage::class);
        $acfMock->expects($this->once())
                ->method('acfAddOptionsSubPage')
                ->with([
                    'page_title'  => function_exists('__') ? __('Volunteer Integration settings', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN) : 'Volunteer Integration settings',
                    'menu_title'  => function_exists('__') ? __('Settings', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN) : 'Settings',
                    'menu_slug'   => 'volunteer-integration-settings',
                    'parent_slug' => 'edit.php?post_type='.PostTypes\Assignment::$postType,
                    'capability'  => 'manage_options',
                ]);

        $optionsPage = new OptionsPage($acfMock);
        $optionsPage->registerOptionsPage();
    }
}