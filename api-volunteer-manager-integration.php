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
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;

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
    if (class_exists('AcfExportManager')) {
        $acfExportManager = new AcfExportManager();
        $acfExportManager->setTextdomain('api-volunteer-manager-integration');
        $acfExportManager->setExportFolder(
            API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/php/AcfFields/'
        );
        $acfExportManager->autoExport([
            'api-volunteer-manager-integration-settings' => 'group_61ea7a87e8aaa',
        ]);
        $acfExportManager->import();
    }
});


(new APIVolunteerManagerIntegration\App())->init(DIContainerFactory::create(), new PluginManager());
