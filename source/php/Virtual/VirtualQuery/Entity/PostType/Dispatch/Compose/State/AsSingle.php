<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsSingle implements VQComposableQuery
{
    function compose(WP_Query $wpQuery): WP_Query
    {
        $wpQuery->is_singular = true;
        $wpQuery->is_single   = true;
        $wpQuery->is_archive  = false;

        return $wpQuery;
    }
}