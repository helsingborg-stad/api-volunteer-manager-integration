<?php

namespace APIVolunteerManagerIntegration\Model;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Employee;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\SignUp;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Spots;

final class VolunteerAssignment
{
    public bool $internal;
    public SignUp $signUp;
    public Employee $employee;
    public Spots $spots;

    public string $description;
    public string $qualifications;
    public string $schedule;
    public string $benefits;

    public function __construct(
        SignUp $signUp,
        Spots $spots,
        Employee $employee,
        bool $internal,
        string $description,
        string $qualifications,
        string $schedule,
        string $benefits
    ) {
        $this->internal       = $internal;
        $this->signUp         = $signUp;
        $this->spots          = $spots;
        $this->employee       = $employee;
        $this->description    = $description;
        $this->qualifications = $qualifications;
        $this->schedule       = $schedule;
        $this->benefits       = $benefits;
    }
}