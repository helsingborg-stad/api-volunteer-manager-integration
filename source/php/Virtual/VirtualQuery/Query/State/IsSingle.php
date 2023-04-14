<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class IsSingle implements VQState {

	private string $postTypeSlug;

	public function __construct( string $postTypeSlug ) {
		$this->postTypeSlug = $postTypeSlug;
	}

	public function match( VQContext $context ): bool {
		$includesPostTypeSlug =
			fn( string $path, string $slug ): bool => strpos( $path, $slug ) !== false;
		$sameFirstPath        =
			fn( string $path, string $slug ): bool => ( explode( '/', $path )[0] ?? true ) === ( explode( '/', $slug )[0] ?? false );
		$pathLengthMinusOne   =
			fn( string $path, string $slug ): bool => ( count( explode( '/', $path ) ) - 1 ) === count( explode( '/', $slug ) );

		return
			$includesPostTypeSlug( $context->getPath(), $this->postTypeSlug )
			&& $sameFirstPath( $context->getPath(), $this->postTypeSlug )
			&& $pathLengthMinusOne( $context->getPath(), $this->postTypeSlug );
	}
}