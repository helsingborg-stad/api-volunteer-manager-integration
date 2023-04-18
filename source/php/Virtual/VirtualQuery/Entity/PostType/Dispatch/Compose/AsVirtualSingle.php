<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Generic\WithQueryVars;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Generic\WithReset;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Posts\WithPostCount;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Posts\WithPostsAsPostType;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\State\AsSingle;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Composer\QueryComposer;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsVirtualSingle implements VQComposableQuery
{

    private string $postType;
    private VQPosts $source;

    public function __construct(VQPosts $source, string $postType)
    {
        $this->postType = $postType;
        $this->source   = $source;
    }

    function compose(WP_Query $wpQuery): WP_Query
    {
        return QueryComposer::compose([
            new WithReset(),
            new WithQueryVars([
                'post_type'     => $this->postType,
                'name'          => $wpQuery->query_vars['name'],
                $this->postType => $wpQuery->query_vars['name'],
            ]),
            new AsSingle(),
            new WithPostsAsPostType(
                $this->source->getPostsByName($wpQuery->query_vars['name']),
                $this->postType
            ),
            new WithPostCount(1),
        ], $wpQuery);
    }
}