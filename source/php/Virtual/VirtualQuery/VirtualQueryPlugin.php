<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery;


use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntity;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\DispatchWpQuery;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\VQPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\RegisterPostTypes;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\ViewControllers;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VirtualQueryFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQ;

abstract class VirtualQueryPlugin implements VQPlugin {

	public function init( VQContextFactory $contextFactory ): void {
		foreach (
			$this->pluggables(
				$this->virtualQuery( $contextFactory ),
				$contextFactory
			) as $pluggable
		) {
			foreach ( $pluggable->toHooks() as $type => $hooks ) {
				foreach ( $hooks as $params ) {
					[ $handle, $callback, $priority, $acceptedArgs ] = [
						$params[0],
						$params[1],
						$params[2] ?? 10,
						$params[3] ?? 1,
					];

					switch ( $type ) {
						case'filters':
						{
							add_filter( $handle, $callback, $priority, $acceptedArgs );
						}
						case 'actions':
						{
							add_action( $handle, $callback, $priority, $acceptedArgs );
						}
					}
				}
			}
		}
	}

	/**
	 * @param VQ               $vq
	 * @param VQContextFactory $contextFactory
	 *
	 * @return array<int, VQPluggable>
	 */
	private function pluggables( VQ $vq, VQContextFactory $contextFactory ): array {
		return [
			new RegisterPostTypes( $vq ),
			new DispatchWpQuery( $vq, $contextFactory ),
			new ViewControllers( $vq, $contextFactory ),
		];
	}

	function virtualQuery( VQContextFactory $contextFactory ): VQ {
		return VirtualQueryFactory::createFromEntitiesWithSources(
			$this->entities(),
			$this->source()
		);
	}

	/**
	 *  Virtual entities used for creating virtual post types, taxonomies etc.
	 *
	 * @return array<int, VQEntity>
	 */
	abstract function entities(): array;

	/**
	 * @return array<string, VQPosts>
	 */
	abstract function source(): array;
}