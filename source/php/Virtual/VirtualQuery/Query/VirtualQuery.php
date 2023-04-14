<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\Posts\NullPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\VirtualPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\VQPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntityFactory;

class VirtualQuery implements VQ {
	/**
	 * @var array<int, VQDispatchable|VQControllable|VQArrayable> $dispatchables
	 */
	public array $dispatchables = [];
	private array $sources;

	/**
	 * @param array<string, VQPosts> $sources
	 */
	public function __construct( array $sources ) {
		$this->sources = $sources;
	}

	public function fromSource( string $sourceId ): VQEntityFactory {
		return new class( $this, $sourceId ) implements VQEntityFactory {
			private VirtualQuery $parent;
			private string $sourceId;

			public function __construct( VirtualQuery $parent, string $sourceId ) {
				$this->parent   = $parent;
				$this->sourceId = $sourceId;
			}

			public function toPostType( string $postType ): VQPostType {
				$virtualPostType = new VirtualPostType(
					$postType,
					$this->parent->resolveSource(
						$this->sourceId,
						VQPosts::class
					) ?? new NullPosts(),
					$this->parent
				);

				$this->parent->dispatchables[] = $virtualPostType;

				return $virtualPostType;
			}
		};
	}

	/**
	 * @template T of VQPosts
	 *
	 * @param string $sourceId
	 * @param class-string<T> $class
	 *
	 * @return T|null
	 */
	public function resolveSource( string $sourceId, string $class ): ?object {
		return $this->sources[ $sourceId ] instanceof $class ? $this->sources[ $sourceId ] : null;
	}

	function toDispatchHandlers(): array {
		$handlers = [];
		foreach ( $this->dispatchables as $dispatchable ) {
			if ( $dispatchable instanceof VQDispatchable ) {
				$handlers = [
					...$handlers,
					...array_values( $dispatchable->toDispatchHandlers() )
				];
			}
		}

		return $handlers;
	}

	function toViewControllers(): array {
		$controllers = [];
		foreach ( $this->dispatchables as $dispatchable ) {
			if ( $dispatchable instanceof VQControllable ) {
				$controllers = [
					...$controllers,
					...array_values( $dispatchable->toViewControllers() )
				];
			}
		}

		return $controllers;
	}

	function toArray(): array {
		$arr = [];
		foreach ( $this->dispatchables as $dispatchable ) {
			if ( $dispatchable instanceof VQArrayable ) {
				$arr[] = $dispatchable->toArray();
			}
		}

		return $arr;
	}
}