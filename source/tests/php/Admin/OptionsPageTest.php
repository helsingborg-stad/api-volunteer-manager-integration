<?php

namespace APIVolunteerManagerIntegration\Tests\Admin;

use APIVolunteerManagerIntegration\Admin\OptionsPage;
use APIVolunteerManagerIntegration\Services\ACFService\ACFAddOptionsSubPage;
use APIVolunteerManagerIntegration\Tests\PluginTestCase;
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
                    'page_title'  =>
                        __('Volunteer Integration settings', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'menu_title'  =>
                        __('Volunteer Integration', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'menu_slug'   => 'volunteer-integration-settings',
                    'parent_slug' => 'options-general.php',
                    'capability'  => 'manage_options',
                ]);

        $optionsPage = new OptionsPage($acfMock);
        $optionsPage->registerOptionsPage();
    }
}