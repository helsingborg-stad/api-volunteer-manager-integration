<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

interface VQPostTypeController {
	public function withController( VQComposableView $controller ): VQPostType;
}