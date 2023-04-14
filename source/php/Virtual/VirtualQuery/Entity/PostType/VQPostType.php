<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQArrayable;

interface VQPostType extends VQArrayable, VQPostTypeController {
	public function withSlug( string $slug ): VQPostType;

	public function withLabel( string $label ): VQPostType;

}