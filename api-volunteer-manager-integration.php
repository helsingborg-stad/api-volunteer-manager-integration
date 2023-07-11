<?php
/**
 * Plugin Name: API Volunteer Manager Integration
 * Plugin URI: https://github.com/helsingborg-stad/api-volunteer-manager-integration
 * Description: Frontend integration for api-volunteer-manager.
 * Version: 1.0.0
 * Author: Nikolas Ramstedt
 * Author URI: https://github.com/helsingborg-stad
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: api-volunteer-manager-integration
 * Domain Path: /languages
 */


use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainerFactory;

if ( ! defined('WPINC')) {
    die();
}

define('API_VOLUNTEER_MANAGER_INTEGRATION_PATH', plugin_dir_path(__FILE__));
define('API_VOLUNTEER_MANAGER_INTEGRATION_URL', plugins_url('', __FILE__));
define('API_VOLUNTEER_MANAGER_INTEGRATION_TEMPLATE_PATH', API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'templates/');
define('API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN', 'api-volunteer-manager-integration');
define('API_VOLUNTEER_MANAGER_MODULE_PATH', API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/php/Modularity/');

require_once API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'Public.php';

// Register the autoloader
require __DIR__.'/vendor/autoload.php';

load_plugin_textdomain(
    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN,
    false,
    plugin_basename(dirname(__FILE__)).'/languages/'
);

// Acf auto import and export
add_action('acf/init', function () {
    if (class_exists('\AcfExportManager\AcfExportManager')) {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $acfExportManager = new \AcfExportManager\AcfExportManager();
        $acfExportManager->setTextdomain(API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $acfExportManager->setExportFolder(
            API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/php/AcfFields/'
        );
        $acfExportManager->autoExport([
            'api-volunteer-manager-integration-settings'        => 'group_644ad1b3d7072',
            'api-volunteer-manager-integration-assignment-form' => 'group_64abba2660644',
            'api-volunteer-manager-integration-volunteer-form'  => 'group_64abbfd89cb56',
        ]);
        $acfExportManager->import();
    }
});


(new APIVolunteerManagerIntegration\App())->init(DIContainerFactory::create());
