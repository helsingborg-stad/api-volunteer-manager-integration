<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

use WP_Query;

abstract class AbstractContextFactory implements VQContextFactory, WPQueryContext
{
    function createContext(): VQContext
    {
        return new class($this) implements VQContext {
            private WPQueryContext $wpQueryContext;

            public function __construct(WPQueryContext $wpQueryContext)
            {
                $this->wpQueryContext = $wpQueryContext;
            }

            function getPath(): string
            {
                return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
            }

            function getQuery(): WP_Query
            {
                return $this->wpQueryContext->getQuery();
            }
        };
    }
}