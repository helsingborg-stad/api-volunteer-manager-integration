<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context;

use WP_Query;

interface WPQueryContext {
	function getQuery(): WP_Query;
}