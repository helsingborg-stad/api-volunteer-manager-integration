<?php

namespace APIVolunteerManagerIntegration\PostTypes\Assignment;

use APIVolunteerManagerIntegration\Helper\PluginManager\FilterHookSubscriber;

class OverridePostTypeSlug implements FilterHookSubscriber
{
    public function changePostTypeSlug(array $args, string $postType): array
    {
        if ($postType === 'vol-assignment') {
            $args['rewrite']['slug'] = 'volontaruppdrag';
        }

        return $args;
    }

    public static function addFilters(): array
    {
        return [['register_post_type_args', 'changePostTypeSlug', 10, 2]];
    }
}