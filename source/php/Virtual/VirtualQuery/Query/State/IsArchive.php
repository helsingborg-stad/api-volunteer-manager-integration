<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class IsArchive implements VQState {
	private string $postType;

	public function __construct( string $postType ) {

		$this->postType = $postType;
	}

	public function match( VQContext $context ): bool {
		return ( $context->getQuery()->query_vars['post_type'] ?? false ) === $this->postType
		       && empty( $context->getQuery()->query_vars['name'] );
	}
}