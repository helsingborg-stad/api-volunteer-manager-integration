<?php

namespace APIVolunteerManagerIntegration\PostTypes\Assignment;

use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\PostTypes\Assignment;
use APIVolunteerManagerIntegration\Services\WPService\GetPostType;

class PreventRobots implements ActionHookSubscriber
{
    protected GetPostType $wp;

    public function __construct(GetPostType $wp)
    {
        $this->wp = $wp;
    }

    public static function addActions()
    {
        return [['wp_head', 'setNoIndexNoFollowMeta']];
    }

    public function setNoIndexNoFollowMeta(): void
    {
        if (defined('VOLUNTEER_MANAGER_INTEGRATION_ASSIGNMENT_HIDDEN') && $this->wp->getPostType() === Assignment::$postType) {
            echo '<meta name="robots" content="noindex,nofollow">';
        }
    }
}
