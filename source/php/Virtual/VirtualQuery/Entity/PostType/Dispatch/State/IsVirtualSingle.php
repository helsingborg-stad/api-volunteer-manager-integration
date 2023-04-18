<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Posts\VirtualPostExists;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Query\IsSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class IsVirtualSingle implements VQState
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
            new IsSingle($this->postType),
            new VirtualPostExists(
                fn() => ! empty($this->source->getPostsByName($context->getQuery()->query_vars['name']))
            ),
        ]);
    }
}