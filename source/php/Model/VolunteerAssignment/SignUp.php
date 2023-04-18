<?php

namespace APIVolunteerManagerIntegration\Model\VolunteerAssignment;

class SignUp
{
    public array $methods;
    public string $link;
    public string $email;
    public string $phone;

    public function __construct(
        array $methods,
        string $email,
        string $link,
        string $phone
    ) {
        $this->methods = $methods;
        $this->email   = $email;
        $this->link    = $link;
        $this->phone   = $phone;
    }
}