<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQ;

interface VQPlugin {
	function init( VQContextFactory $contextFactory ): void;

	function virtualQuery( VQContextFactory $contextFactory ): VQ;
}