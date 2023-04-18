<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQ;

interface VQApp
{
    function init(VQContextFactory $contextFactory): void;

    function virtualQuery(VQContextFactory $contextFactory): VQ;
}