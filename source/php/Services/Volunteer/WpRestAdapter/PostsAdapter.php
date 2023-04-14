<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer\WpRestAdapter;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use WP_Post;

abstract class PostsAdapter implements VQPosts {

	private WpRestClient $repository;
	private string $postType;

	public function __construct( WpRestClient $repository, string $postType ) {
		$this->repository = $repository;
		$this->postType   = $postType;
	}

	abstract function toPost( array $data ): WP_Post;

	function getPostsByName( string $name ): array {
		return array_values(
			array_map(
				[ $this, 'toPost' ],
				$this->repository->getPosts( $this->postType, [ 'slug' => $name ] )
			)
		);
	}

	function getPosts(): array {
		return array_values(
			array_map(
				[ $this, 'toPost' ],
				$this->repository->getPosts( $this->postType, [] )
			)
		);
	}
}