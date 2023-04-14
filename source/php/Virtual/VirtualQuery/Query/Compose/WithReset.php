<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class WithReset implements VQComposableQuery {
	function compose( WP_Query $wpQuery ): WP_Query {
		$wpQuery->init();

		return $wpQuery;
	}
}