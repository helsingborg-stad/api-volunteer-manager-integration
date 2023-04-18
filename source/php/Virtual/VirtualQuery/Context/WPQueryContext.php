<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

use WP_Query;

interface WPQueryContext
{
    function getQuery(): WP_Query;
}