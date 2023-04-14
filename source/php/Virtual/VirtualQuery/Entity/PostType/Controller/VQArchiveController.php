<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualArchiveState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits\VirtualBootstrapState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

/**
 * @uses VirtualSingleState, VirtualBootstrapState
 */
abstract class VQArchiveController implements VQComposableView, VQArchive {
	use VirtualArchiveState, VirtualBootstrapState;

	function compose( array $data ): array {
		return $this->archive( $data );
	}
}