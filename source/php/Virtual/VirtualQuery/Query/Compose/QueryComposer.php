<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class QueryComposer {
	/**
	 * @param VQComposableQuery[] $composers
	 * @param WP_Query            $wpQuery
	 *
	 * @return WP_Query
	 */
	public static function compose( array $composers, WP_Query $wpQuery ): WP_Query {
		return array_reduce(
			$composers,
			fn( WP_Query $wpQuery, VQComposableQuery $composer ): WP_Query => $composer->compose( $wpQuery ),
			$wpQuery
		);
	}
}