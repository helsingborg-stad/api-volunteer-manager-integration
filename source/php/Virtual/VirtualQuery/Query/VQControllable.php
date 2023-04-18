<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

interface VQControllable
{
    /**
     * @return array<int, VQComposableView>
     */
    function toViewControllers(): array;
}