<?php

/**
 * Plugin Name:       API Volunteer VirtualQuery Integration
 * Plugin URI:        https://github.com/helsingborg-stad/api-volunteer-manager-integration
 * Description:       Frontend integration for api-volunteer-manager.
 * Version:           1.0.0
 * Author:            Nikolas Ramstedt
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       api-volunteer-manager-integration
 * Domain Path:       /languages
 */

use APIVolunteerManagerIntegration\App;
use APIVolunteerManagerIntegration\Services\WpRest\Local\LocalWpRestClient;

// Protect against direct file access
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'API_VOLUNTEER_MANAGER_INTEGRATION_PATH', plugin_dir_path( __FILE__ ) );
define( 'API_VOLUNTEER_MANAGER_INTEGRATION_URL', plugins_url( '', __FILE__ ) );
define(
	'API_VOLUNTEER_MANAGER_INTEGRATION_TEMPLATE_PATH',
	API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'templates/'
);
define( 'API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN', 'api-volunteer-manager-integration' );

load_plugin_textdomain(
	API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN,
	false,
	API_VOLUNTEER_MANAGER_INTEGRATION_PATH . '/languages'
);

require_once API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'Public.php';

// Register the autoloader
require __DIR__ . '/vendor/autoload.php';

// Acf auto import and export
add_action( 'acf/init', function () {
	if ( class_exists( 'AcfExportManager' ) ) {
		$acfExportManager = new AcfExportManager();
		$acfExportManager->setTextdomain( 'api-volunteer-manager-integration' );
		$acfExportManager->setExportFolder(
			API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'source/php/AcfFields/'
		);
		$acfExportManager->autoExport( [
			'api-volunteer-manager-integration-settings' => 'group_61ea7a87e8aaa',
			//Update with acf id here, settings view
		] );
		$acfExportManager->import();
	}
} );

$json = file_exists( API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'local.json' )
	? file_get_contents( API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'local.json' )
	: apiVolunteerManagerIntegrationFakeJsonString();


// Start application
new App( LocalWpRestClient::createFromJson( $json ) );
