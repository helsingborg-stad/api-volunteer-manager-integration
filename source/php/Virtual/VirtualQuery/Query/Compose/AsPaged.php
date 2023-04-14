<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsPaged implements VQComposableQuery {

	function compose( WP_Query $wpQuery ): WP_Query {
		return $wpQuery;
	}
}