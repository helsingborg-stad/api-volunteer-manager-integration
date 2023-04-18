<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\AsVirtualSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\IsVirtualSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Composer\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQDispatchHandler;
use WP_Query;

class SingleQuery implements VQDispatchHandler
{

    private string $postType;

    private VQPosts $source;

    public function __construct(VQPosts $source, string $postType)
    {
        $this->source   = $source;
        $this->postType = $postType;
    }

    function compose(WP_Query $wpQuery): WP_Query
    {
        return QueryComposer::compose([
            new AsVirtualSingle($this->source, $this->postType),
        ], $wpQuery);
    }

    public function match(VQContext $context): bool
    {
        return StateReducer::match($context, [
            new IsVirtualSingle($this->source, $this->postType),
        ]);
    }
}