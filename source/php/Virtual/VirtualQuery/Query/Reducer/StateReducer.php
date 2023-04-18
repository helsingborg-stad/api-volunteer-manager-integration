<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Reducer;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQState;

class StateReducer
{
    /**
     * @param  VQContext  $context
     * @param  VQState[]  $states
     *
     * @return bool
     */
    public static function match(VQContext $context, array $states): bool
    {
        return array_reduce(
            $states,
            fn(bool $isValid, VQState $state) => $isValid && $state->match($context),
            true
        );
    }
}