<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Posts\WithPostCount;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Posts\WithPostsAsPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\State\AsArchive;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Composer\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsVirtualArchive implements VQComposableQuery
{
    private string $postType;
    private VQPosts $source;

    function __construct(VQPosts $source, string $postType)
    {
        $this->postType = $postType;
        $this->source   = $source;
    }

    function compose(WP_Query $wpQuery): WP_Query
    {
        return QueryComposer::compose([
            new AsArchive(),
            new WithPostsAsPostType(
                $this->source->getPosts(),
                $this->postType
            ),
            new WithPostCount(count($this->source->getPosts())),
        ], $wpQuery);
    }
}