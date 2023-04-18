<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

interface VQContextFactory
{
    function createContext(): VQContext;
}