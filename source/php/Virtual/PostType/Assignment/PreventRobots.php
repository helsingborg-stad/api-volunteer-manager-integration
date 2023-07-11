<?php

namespace APIVolunteerManagerIntegration\Virtual\PostType\Assignment;

use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\Services\WPService\GetPostType;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;

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
        if (defined('VOLUNTEER_MANAGER_INTEGRATION_ASSIGNMENT_HIDDEN') && $this->wp->getPostType() === Assignment::POST_TYPE) {
            echo '<meta name="robots" content="noindex,nofollow">';
        }
    }
}
