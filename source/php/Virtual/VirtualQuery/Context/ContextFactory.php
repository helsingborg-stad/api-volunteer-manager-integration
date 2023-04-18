<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

use WP_Query;

class ContextFactory extends AbstractContextFactory
{

    private WP_Query $wpQuery;

    public function __construct(WP_Query $wpQuery)
    {
        $this->wpQuery = $wpQuery;
    }

    function getQuery(): WP_Query
    {
        return $this->wpQuery;
    }
}