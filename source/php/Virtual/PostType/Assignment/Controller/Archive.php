<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Assignment\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;

class Archive extends VQArchiveController {
	function archive( array $data ): array {
		return $data;
	}
}