<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context;

interface ServerRequestContext
{
    function getPath(): string;
}