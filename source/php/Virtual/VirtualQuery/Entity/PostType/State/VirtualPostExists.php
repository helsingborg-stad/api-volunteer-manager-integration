<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;
use Closure;

class VirtualPostExists implements VQState {

	/**
	 * @var Closure():bool $postExist
	 */
	private Closure $postExists;

	/**
	 * @param Closure():bool $closure
	 */
	public function __construct( Closure $closure ) {
		$this->postExists = $closure;
	}

	public function match( VQContext $context ): bool {
		return ( $this->postExists )();
	}
}