<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable;

interface VQPluggable
{
    /**
     * @return array<string, array<int, array{0: string, 1: callable, 2: int|null, 3: int|null}>>
     */
    function toHooks(): array;
}