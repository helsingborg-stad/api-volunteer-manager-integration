<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQFromSource;

interface VQ extends VQArrayable, VQFromSource, VQDispatchable, VQControllable
{
}