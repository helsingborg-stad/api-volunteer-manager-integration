<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Helper\HttpClient\CurlClientFactory;
use APIVolunteerManagerIntegration\Services\WpRest\Local\LocalWpRestClient;
use APIVolunteerManagerIntegration\Services\WpRest\Remote\RemoteWpRestClient;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\Routes;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\GlobalContextFactory;

class App {
	public function __construct() {
		$virtualQuery = new Routes( $this->createWpRestClient() );
		$virtualQuery->init( new GlobalContextFactory() );
	}

	public function createWpRestClient(): WpRestClient {
		$createClient = $this->useLocalWpRestClient()
			? fn(): WpRestClient => LocalWpRestClient::createFromJson(
				file_get_contents(
					API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'local.json'
				)
			)
			: fn(): WpRestClient => new RemoteWpRestClient(
				'https://modul-test.helsingborg.io/volontar/json',
				new CurlClientFactory()
			);

		return $createClient();
	}

	/** @noinspection PhpUndefinedConstantInspection */
	public function useLocalWpRestClient(): bool {
		return ( defined( 'WP_ENVIRONMENT_TYPE' )
		         && WP_ENVIRONMENT_TYPE === 'local' )
		       && file_exists( API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'local.json' );
	}
}
