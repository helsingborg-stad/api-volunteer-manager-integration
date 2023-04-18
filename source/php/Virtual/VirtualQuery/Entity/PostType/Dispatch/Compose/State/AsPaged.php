<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\State;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class AsPaged implements VQComposableQuery
{

    function compose(WP_Query $wpQuery): WP_Query
    {
        return $wpQuery;
    }
}