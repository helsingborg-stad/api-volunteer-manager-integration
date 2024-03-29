<?php

namespace APIVolunteerManagerIntegration\PostTypes\Assignment;

use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\PostTypes\Assignment;

class PreventAlgolia implements ActionHookSubscriber
{
    public static function addActions()
    {
        return [['AlgoliaIndex/IndexablePostTypes', 'excludePostType']];
    }

    public function excludePostType(array $postTypes): array
    {
        return defined('VOLUNTEER_MANAGER_INTEGRATION_ASSIGNMENT_HIDDEN') ? array_filter($postTypes,
            fn($postType) => $postType !== Assignment::$postType) : $postTypes;
    }
}
