<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\IsVirtualArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;

trait VirtualArchiveState
{
    protected string $postType;

    protected VQPosts $source;

    public function match(VQContext $context): bool
    {
        return StateReducer::match($context, [
            new IsVirtualArchive($this->source, $this->postType),
        ]);
    }
}