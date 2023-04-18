<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\AbstractPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\VQPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable\VQPluggableAction;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQDispatchable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQDispatcher;

class DispatchWpQuery extends AbstractPluggable implements VQPluggable, VQPluggableAction, VQDispatcher
{
    private VQDispatchable $dispatchable;
    private VQContextFactory $contextFactory;

    public function __construct(VQDispatchable $dispatchable, VQContextFactory $contextFactory)
    {
        $this->dispatchable   = $dispatchable;
        $this->contextFactory = $contextFactory;
    }

    public static function addActions(): array
    {
        return [
            ['wp', 'dispatch', 10, 1,],
        ];
    }

    public function dispatch(): void
    {
        $context = $this->contextFactory->createContext();
        foreach ($this->dispatchable->toDispatchHandlers() as $handler) {
            if ($handler->match($context)) {
                $handler->compose($context->getQuery());

                return;
            }
        }
    }
}