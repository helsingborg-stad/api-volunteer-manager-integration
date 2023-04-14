<?php

namespace APIVolunteerManagerIntegration\Services\WpRest\Local;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use Closure;
use Exception;
use function json_decode;

class LocalWpRestClient implements WpRestClient {
	/**
	 * @var array<int, array> $posts
	 */
	protected array $posts;

	/**
	 * @var array<int, array> $terms
	 */
	protected array $terms;

	/**
	 * @var array<int, string> $types
	 */
	protected array $types;
	/**
	 * @var array<int, string> $taxonomies
	 */
	protected array $taxonomies;

	public function __construct( array $args ) {
		$this->types      = $args['types'] ?? [];
		$this->posts      = $args['posts'] ?? [];
		$this->terms      = $args['terms'] ?? [];
		$this->taxonomies = $args['taxonomies'] ?? [];
	}

	public static function createFromJson( string $json ): WpRestClient {
		try {
			$args = json_decode( $json, true, 512, JSON_THROW_ON_ERROR );
		} catch ( Exception $e ) {
			$args = [];
		}

		return new self( [
			'types'      => $args['types'] ?? [],
			'posts'      => $args['posts'] ?? [],
			'terms'      => $args['terms'] ?? [],
			'taxonomies' => $args['taxonomies'] ?? [],
		] );
	}

	public function getTaxonomies(): array {
		return $this->taxonomies;
	}

	public function getPosts( string $postType, ?array $args = null ): array {
		$compositeFilterFn = fn( array $filters ): Closure => fn( array $post ): bool => array_reduce(
			$filters,
			fn( $prev, Closure $filter ) => $prev && $filter( $post ),
			true
		);

		return array_filter( $this->posts, $compositeFilterFn( [
			'slug'     => fn( array $post ): bool => ! isset( $args['slug'] ) || $post['slug'] === $args['slug'],
			'postType' => fn( array $post ): bool => ! empty( $post['type'] ) && $post['type'] === $postType,
		] ) );
	}

	public function getTerms( string $taxonomy, ?array $args = null ): array {
		return array_filter( $this->terms, fn( array $term ): bool => $term['taxonomy'] === $taxonomy );
	}

	public function getTypes(): array {
		return $this->types;
	}
}