<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsArchive implements VQComposableQuery
{
    function compose(WP_Query $wpQuery): WP_Query
    {
        $wpQuery->is_singular = false;
        $wpQuery->is_single   = false;
        $wpQuery->is_archive  = true;

        return $wpQuery;
    }
}