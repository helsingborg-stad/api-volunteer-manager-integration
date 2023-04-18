<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use WP_Query;

interface VQComposableQuery
{
    function compose(WP_Query $wpQuery): WP_Query;
}