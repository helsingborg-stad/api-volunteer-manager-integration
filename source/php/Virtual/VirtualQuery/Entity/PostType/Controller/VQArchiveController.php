<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits\VirtualArchiveState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits\VirtualBootstrapState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits\VirtualSingleState;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;

/**
 * @uses VirtualSingleState, VirtualBootstrapState
 */
abstract class VQArchiveController implements VQComposableView, VQArchive
{
    use VirtualArchiveState, VirtualBootstrapState;

    protected string $postType;

    protected VQPosts $source;

    function compose(array $data): array
    {
        return $this->archive($data);
    }
}