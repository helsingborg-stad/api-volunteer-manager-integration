<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Assignment\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQSingleController;

class Single extends VQSingleController {
	function single( array $data ): array {
		return $data;
	}
}