<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;


use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualBootstrapState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualSingleState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

abstract class VQSingleController implements VQComposableView, VQSingle {
	use VirtualSingleState;

	/**
	 * @use VirtualBootstrapState
	 */
	use VirtualBootstrapState;

	function compose( array $data ): array {
		return $this->single( $data );
	}
}