<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Post;

class WithPostsAsPostType extends WithPosts implements VQComposableQuery {
	public function __construct( array $posts, string $postType ) {
		parent::__construct( $posts, function ( WP_Post $post ) use ( $postType ) {
			$post->post_type = $postType;

			return $post;
		} );
	}
}