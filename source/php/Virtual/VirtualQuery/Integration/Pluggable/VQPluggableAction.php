<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable;

interface VQPluggableAction {
	/**
	 * @return array<int, array{0: string, 1: string, 2: ?int, 3: ?int}>
	 */
	static function addActions(): array;

}