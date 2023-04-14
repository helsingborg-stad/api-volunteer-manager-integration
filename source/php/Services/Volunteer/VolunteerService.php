<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQArrayable;

interface VolunteerService extends VQArrayable {
	function assignments(): VQPosts;
}