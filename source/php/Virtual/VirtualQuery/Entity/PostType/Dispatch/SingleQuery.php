<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch;

use APIVolunteerManagerIntegration\Helper\Path;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualSingleState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\AsSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\WithPostCount;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\WithPostsAsPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Compose\WithReset;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Dispatch\VQDispatchHandler;
use WP_Query;

class SingleQuery implements VQDispatchHandler {
	use VirtualSingleState {
		match as traitState;
	}

	private string $postType;
	private string $postName;

	private VQPosts $source;

	public function __construct( VQPosts $source, string $postType ) {
		$this->source   = $source;
		$this->postType = $postType;
	}

	public function match( VQContext $context ): bool {
		$this->postName = Path::getLastPathItem( $context->getPath() );

		return $this->traitState( $context );
	}

	function compose( WP_Query $wpQuery ): WP_Query {
		return QueryComposer::compose( [
			new WithReset(),
			new AsSingle(),
			new WithPostsAsPostType(
				$this->source->getPostsByName( $wpQuery->query_vars['name'] ),
				$this->postType
			),
			new WithPostCount( 1 ),
		], $wpQuery );
	}
}