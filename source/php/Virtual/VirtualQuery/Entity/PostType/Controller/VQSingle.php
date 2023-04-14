<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

interface VQSingle extends VQComposableView {
	function single( array $data ): array;
}