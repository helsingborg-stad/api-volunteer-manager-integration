<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer\WpRestAdapter;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use WP_Post;

abstract class PostsAdapter implements VQPosts
{

    private WpRestClient $wpRestClient;
    private string $postType;

    public function __construct(WpRestClient $wpRestClient, string $postType)
    {
        $this->wpRestClient = $wpRestClient;
        $this->postType     = $postType;
    }

    abstract function toPost(array $data): WP_Post;

    function getPostsByName(string $name): array
    {
        return array_values(
            array_map(
                [$this, 'toPost'],
                $this->wpRestClient->getPosts($this->postType,
                    ['slug' => $name, 'acf_format' => 'standard', '_embed' => true])
            )
        );
    }

    function getPosts(): array
    {
        return array_values(
            array_map(
                [$this, 'toPost'],
                $this->wpRestClient->getPosts($this->postType, ['acf_format' => 'standard', '_embed' => true])
            )
        );
    }
}