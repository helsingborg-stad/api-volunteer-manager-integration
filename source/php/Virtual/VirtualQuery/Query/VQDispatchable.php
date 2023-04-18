<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

interface VQDispatchable extends VQArrayable
{
    /**
     * @return array<int, VQDispatchHandler>
     */
    function toDispatchHandlers(): array;
}