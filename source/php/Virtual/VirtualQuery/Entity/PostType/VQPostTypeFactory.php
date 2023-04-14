<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType;

interface VQPostTypeFactory {
	public function toPostType( string $postType ): VQPostType;
}