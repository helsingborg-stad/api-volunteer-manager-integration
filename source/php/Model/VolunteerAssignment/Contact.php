<?php

namespace APIVolunteerManagerIntegration\Model\VolunteerAssignment;

class Contact
{
    public string $name;
    public ?string $email;
    public ?string $phone;

    public function __construct(string $name, ?string $email = null, ?string $phone = null)
    {
        $this->name  = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
}