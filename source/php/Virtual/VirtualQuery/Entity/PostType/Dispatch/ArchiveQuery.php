<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\AsVirtualArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\IsVirtualArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Composer\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer\StateReducer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQDispatchHandler;
use WP_Query;

class ArchiveQuery implements VQDispatchHandler
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
            new AsVirtualArchive($this->source, $this->postType),
        ], $wpQuery);
    }

    public function match(VQContext $context): bool
    {
        return StateReducer::match($context, [
            new IsVirtualArchive($this->source, $this->postType),
        ]);
    }
}