<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;

trait VirtualBootstrapState
{
    protected string $postType;

    protected VQPosts $source;

    public function bootstrap(VQPosts $source, string $postType): void
    {
        $this->postType = $postType;
        $this->source   = $source;
    }
}