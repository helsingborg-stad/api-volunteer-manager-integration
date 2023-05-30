<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function addAction().
 */
interface AddAction
{
    /**
     * Hooks a function or method to a specific action.
     *
     * @param  string  $tag  The name of the action to which the function or method should be hooked.
     * @param  callable  $callback  The callback function or method to be executed.
     * @param  int  $priority  Optional. The priority at which the function should be executed. Default is 10.
     * @param  int  $accepted_args  Optional. The number of arguments the function accepts. Default is 1.
     */
    public function addAction(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void;
}
