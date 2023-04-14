<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsPostType implements VQComposableQuery {
	function compose( WP_Query $wpQuery ): WP_Query {
		$wpQuery->is_singular = true;
		$wpQuery->is_single   = true;
		$wpQuery->is_archive  = false;

		return $wpQuery;
	}
}