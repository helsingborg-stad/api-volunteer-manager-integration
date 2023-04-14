<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\Posts;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;

class NullPosts implements VQPosts {

	function getPostsByName( string $name ): array {
		return [];
	}

	function getPosts(): array {
		return [];
	}
}