<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

interface VQArchive extends VQComposableView {
	function archive( array $data ): array;
}