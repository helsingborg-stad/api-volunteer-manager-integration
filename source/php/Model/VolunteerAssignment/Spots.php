<?php

namespace APIVolunteerManagerIntegration\Model\VolunteerAssignment;

class Spots
{
    public int $available;

    public function __construct(int $available)
    {
        $this->available = $available;
    }
}