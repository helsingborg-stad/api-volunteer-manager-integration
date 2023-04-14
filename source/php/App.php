<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\Routes;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\GlobalContextFactory;

class App {
	public function __construct( WpRestClient $repository ) {
		$virtualQuery = new Routes( $repository );
		$virtualQuery->init( new GlobalContextFactory() );
	}
}
