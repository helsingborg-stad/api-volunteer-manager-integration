<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Dispatch\Compose\Generic;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableQuery;
use WP_Query;

class WithQueryVars implements VQComposableQuery
{
    private array $queryVars;

    public function __construct(array $queryVars)
    {
        $this->queryVars = $queryVars;
    }

    function compose(WP_Query $wpQuery): WP_Query
    {
        $wpQuery->query = $this->queryVars;
        foreach ($this->queryVars as $key => $value) {
            $wpQuery->set($key, $value);
        }

        return $wpQuery;
    }
}