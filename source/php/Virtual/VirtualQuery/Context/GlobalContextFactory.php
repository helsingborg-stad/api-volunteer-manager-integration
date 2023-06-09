<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

use WP_Query;

class GlobalContextFactory extends AbstractContextFactory
{

    function getQuery(): WP_Query
    {
        global $wp_query;

        return $wp_query;
    }
}