<?php

// Get around direct access blockers.
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/../../../');
}

define('API_VOLUNTEER_MANAGER_INTEGRATION_PATH', __DIR__ . '/../../../');
define('API_VOLUNTEER_MANAGER_INTEGRATION_URL', 'https://example.com/wp-content/plugins/' . 'modularity-api-volunteer-manager-integration');
define('API_VOLUNTEER_MANAGER_INTEGRATION_TEMPLATE_PATH', API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'templates/');


// Register the autoloader
$loader = require __DIR__ . '/../../../vendor/autoload.php';
$loader->addPsr4('APIVolunteerManagerIntegration\\Test\\', __DIR__ . '/../php/');

require_once __DIR__ . '/PluginTestCase.php';
