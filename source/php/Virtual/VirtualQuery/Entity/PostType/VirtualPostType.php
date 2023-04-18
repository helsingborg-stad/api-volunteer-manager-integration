<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQArchiveController;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQSingleController;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\ArchiveQuery;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\SingleQuery;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntityFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQFromSource;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQArrayable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQControllable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQDispatchable;

class VirtualPostType implements VQArrayable, VQDispatchable, VQControllable, VQPostType, VQFromSource
{
    private string $postType;
    private string $slug;
    private string $label;

    private VQPosts $source;
    private VQFromSource $sourceFactory;
    /**
     * @var array<int, VQComposableView>
     */
    private array $controllers;

    public function __construct(string $postType, VQPosts $source, VQFromSource $sourceFactory)
    {
        $this->postType      = $postType;
        $this->label         = $postType;
        $this->slug          = $postType;
        $this->source        = $source;
        $this->sourceFactory = $sourceFactory;
        $this->controllers   = [];
    }

    public function withSlug(string $slug): VQPostType
    {
        $this->slug = $slug;

        return $this;
    }

    public function withLabel(string $label): VQPostType
    {
        $this->label = $label;

        return $this;
    }

    function toDispatchHandlers(): array
    {
        return [
            new SingleQuery($this->source, $this->postType),
            new ArchiveQuery($this->source, $this->postType),
        ];
    }

    public function withController(VQComposableView $controller): VQPostType
    {
        if ($controller instanceof VQSingleController || $controller instanceof VQArchiveController) {
            $controller->bootstrap($this->source, $this->postType);
        }
        $this->controllers[] = $controller;

        return $this;
    }

    function toViewControllers(): array
    {
        return $this->controllers;
    }

    function toArray(): array
    {
        return [
            'postType' => $this->postType,
            'slug'     => $this->slug,
            'label'    => $this->label,
        ];
    }

    public function fromSource(string $sourceId): VQEntityFactory
    {
        return $this->sourceFactory->fromSource($sourceId);
    }

}