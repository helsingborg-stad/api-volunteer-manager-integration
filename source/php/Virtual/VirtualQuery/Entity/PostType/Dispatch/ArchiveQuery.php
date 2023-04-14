<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualArchiveState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\AsArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\WithPostCount;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\WithPostsAsPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Dispatch\VQDispatchHandler;
use WP_Query;

class ArchiveQuery implements VQDispatchHandler {
	use VirtualArchiveState;

	private string $postType;

	private VQPosts $source;

	public function __construct( VQPosts $source, string $postType ) {
		$this->source   = $source;
		$this->postType = $postType;
	}

	function compose( WP_Query $wpQuery ): WP_Query {
		return QueryComposer::compose( [
			new AsArchive(),
			new WithPostsAsPostType(
				$this->source->getPosts(),
				$this->postType
			),
			new WithPostCount( count( $this->source->getPosts() ) ),
		], $wpQuery );
	}
}