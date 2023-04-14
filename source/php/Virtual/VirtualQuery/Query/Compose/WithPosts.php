<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use Closure;
use WP_Post;
use WP_Query;

class WithPosts implements VQComposableQuery {

	/**
	 * WP_Post[] $posts
	 */
	private array $posts;

	/**
	 * @param array                         $posts
	 * @param Closure(WP_Post):WP_Post|null $callable
	 */
	public function __construct( array $posts, ?Closure $callable = null ) {
		$this->posts = array_values(
			array_map( $callable ?? fn( WP_Post $post ): WP_Post => $post, $posts )
		);
	}

	function compose( WP_Query $wpQuery ): WP_Query {
		$wpQuery->posts          = $this->posts;
		$wpQuery->post           = $this->posts[0] ?? null;
		$wpQuery->queried_object = $this->posts[0] ?? null;
		$GLOBALS['post']         = $this->posts[0] ?? null;

		return $wpQuery;
	}
}