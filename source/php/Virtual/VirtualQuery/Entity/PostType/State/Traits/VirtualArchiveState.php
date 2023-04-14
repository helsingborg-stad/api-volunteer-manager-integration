<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State\IsArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State\Reducer\StateReducer;

trait VirtualArchiveState {
	private string $postType = '';

	function match( VQContext $context ): bool {
		return StateReducer::match( $context, [
			new IsArchive( $this->postType )
		] );
	}
}