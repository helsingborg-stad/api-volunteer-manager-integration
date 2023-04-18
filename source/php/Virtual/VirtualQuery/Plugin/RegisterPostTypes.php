<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\AbstractPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\VQPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\VQPluggableAction;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQArrayable;

class RegisterPostTypes extends AbstractPluggable implements VQPluggable, VQPluggableAction
{
    private VQArrayable $virtualQuery;

    public function __construct(VQArrayable $postTypeArgs)
    {
        $this->virtualQuery = $postTypeArgs;
    }

    public static function addActions(): array
    {
        return [
            ['init', 'registerPostTypes', 10, 1],
        ];
    }

    public function registerPostTypes(): void
    {
        array_map(
            fn($postTypeArgs) => register_post_type(...$postTypeArgs),
            $this->toRegisterPostTypeArgs($this->virtualQuery)
        );
    }

    public function toRegisterPostTypeArgs(VQArrayable $vq): array
    {
        $postTypes = array_filter(
            $vq->toArray(),
            fn($config) => ! empty($config['postType'])
        );

        return array_map(fn($args) => [
            $args['postType'],
            [
                'public'      => $args['public'] ?? true,
                'label'       => $args['label'] ?? $args['postType'],
                'has_archive' => $args['hasArchive'] ?? true,
                'show_ui'     => $args['showUi'] ?? false,
                'rewrite'     => [
                    'slug'       => $args['slug'] ?? $args['postType'],
                    'with_front' => false,
                ],
            ],
        ], $postTypes);
    }
}