<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\IsVirtualSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;

trait VirtualSingleState
{
    protected string $postType;
    protected VQPosts $source;

    public function match(VQContext $context): bool
    {
        return StateReducer::match($context, [
            new IsVirtualSingle($this->source, $this->postType),
        ]);
    }
}