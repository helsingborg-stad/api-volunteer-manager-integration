<?php

namespace APIVolunteerManagerIntegration\Services\WpRest;

interface WpRestClient {
	/**
	 * @param string $postType
	 * @param array|null $args
	 *
	 * @return array
	 */
	public function getPosts( string $postType, ?array $args = null ): array;

	/**
	 * @param string $taxonomy
	 * @param array|null $args
	 *
	 * @return array
	 */
	public function getTerms( string $taxonomy, ?array $args = null ): array;


	/**
	 * @return array<int, string>
	 */
	public function getTaxonomies(): array;

	/**
	 *
	 * @return array<int, string>
	 */
	public function getTypes(): array;
}