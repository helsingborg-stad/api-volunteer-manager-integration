<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;

interface VQState {
	public function match( VQContext $context ): bool;
}