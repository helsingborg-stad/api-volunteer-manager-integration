<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\AbstractPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\VQPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\VQPluggableAction;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQ;

class RegisterPostTypes extends AbstractPluggable implements VQPluggable, VQPluggableAction {
	private VQ $virtualQuery;

	public function __construct( VQ $virtualQuery ) {
		$this->virtualQuery = $virtualQuery;
	}

	public static function addActions(): array {
		return [
			[ 'init', 'registerPostTypes', 10, 1 ]
		];
	}

	public function registerPostTypes(): void {
		array_map(
			fn( $postTypeArgs ) => register_post_type( ...$postTypeArgs ),
			$this->toRegisterPostTypeArgs( $this->virtualQuery )
		);
	}

	public function toRegisterPostTypeArgs( VQ $vq ): array {
		$postTypes = array_filter(
			$vq->toArray(),
			fn( $config ) => ! empty( $config['postType'] )
		);

		return array_map( fn( $args ) => [
			$args['postType'],
			[
				'public'      => $args['public'] ?? true,
				'label'       => $args['label'] ?? $args['postType'],
				'has_archive' => $args['hasArchive'] ?? true,
				'show_ui'     => $args['showUi'] ?? false,
				'rewrite'     => [
					'slug'       => $args['slug'] ?? $args['postType'],
					'with_front' => false,
				]
			]
		], $postTypes );
	}
}