<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;


use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualBootstrapState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualSingleState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

/**
 * @uses VirtualSingleState, VirtualBootstrapState
 */
abstract class VQSingleController implements VQComposableView, VQSingle {
	use VirtualSingleState, VirtualBootstrapState;

	function compose( array $data ): array {
		return $this->single( $data );
	}
}