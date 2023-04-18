<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Query\IsArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class IsVirtualArchive implements VQState
{
    protected string $postType;
    protected VQPosts $source;

    public function __construct(VQPosts $source, string $postType)
    {
        $this->postType = $postType;
        $this->source   = $source;
    }

    function match(VQContext $context): bool
    {
        return StateReducer::match($context, [
            new IsArchive($this->postType),
        ]);
    }
}