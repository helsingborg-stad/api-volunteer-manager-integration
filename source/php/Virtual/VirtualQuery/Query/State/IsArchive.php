<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\State;

use APIVolunteerManagerIntegration\Helper\Path;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class IsArchive implements VQState {
	private string $postTypeSlug;

	public function __construct( string $postTypeSlug ) {

		$this->postTypeSlug = $postTypeSlug;
	}

	public function match( VQContext $context ): bool {
		$includesPostTypeSlug =
			fn( string $path, string $slug ): bool => strpos( $path, $slug ) !== false;
		$sameLastPath         =
			fn( string $path, string $slug ): bool => PATH::getLastPathItem( $path ) === Path::getLastPathItem( $slug );
		$sameLength           =
			fn( string $path, string $slug ): bool => count( explode( '/', $path ) ) === count( explode( '/', $slug ) );

		return
			$includesPostTypeSlug( $context->getPath(), $this->postTypeSlug )
			&& $sameLastPath( $context->getPath(), $this->postTypeSlug )
			&& $sameLength( $context->getPath(), $this->postTypeSlug );
	}
}