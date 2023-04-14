<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Dispatch\VQDispatchHandler;

interface VQDispatchable extends VQArrayable {
	/**
	 * @return array<int, VQDispatchHandler>
	 */
	function toDispatchHandlers(): array;
}