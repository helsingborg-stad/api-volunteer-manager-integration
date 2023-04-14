<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source;

interface VQPosts {
	function getPostsByName( string $name ): array;

	function getPosts(): array;
}