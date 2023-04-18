<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable;

interface VQPluggableFilter
{

    /**
     * @return array<int, array{0: string, 1: string, 2: ?int, 3: ?int}>
     */
    static function addFilters(): array;
}