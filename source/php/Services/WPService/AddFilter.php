<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function add_filter().
 *
 * @link https://developer.wordpress.org/reference/functions/add_filter/
 */
interface AddFilter
{
    /**
     * Hooks a function or method to a specific filter.
     *
     * @param  string  $tag  The name of the filter to which the function or method should be hooked.
     * @param  callable  $callback  The callback function or method to be executed.
     * @param  int  $priority  Optional. The priority at which the function should be executed. Default is 10.
     * @param  int  $accepted_args  Optional. The number of arguments the function accepts. Default is 1.
     *
     * @return void
     */
    public function addFilter(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void;
}
