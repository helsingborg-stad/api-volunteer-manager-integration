<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Generic;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class WithReset implements VQComposableQuery
{
    function compose(WP_Query $wpQuery): WP_Query
    {
        $wpQuery->init();

        return $wpQuery;
    }
}