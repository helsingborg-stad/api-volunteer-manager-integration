<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits;

use APIVolunteerManagerIntegration\Helper\Path;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\VirtualPostExists;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State\IsSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State\Reducer\StateReducer;

trait VirtualSingleState {
	private string $postTypeSlug;

	private VQPosts $source;

	function match( VQContext $context ): bool {
		return StateReducer::match( $context, [
			new IsSingle( $this->postTypeSlug ),
			new VirtualPostExists(
				fn() => ! empty( $this->source->getPostsByName( Path::getLastPathItem( $context->getPath() ) ) )
			)
		] );
	}
}