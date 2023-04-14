<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class WithPostCount implements VQComposableQuery {
	private int $postCount;

	public function __construct( int $postCount ) {
		$this->postCount = $postCount;
	}

	function compose( WP_Query $wpQuery ): WP_Query {
		$wpQuery->post_count  = $this->postCount;
		$wpQuery->found_posts = $this->postCount;

		return $wpQuery;
	}
}