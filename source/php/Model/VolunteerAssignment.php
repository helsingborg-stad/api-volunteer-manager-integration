<?php

namespace APIVolunteerManagerIntegration\Model;

use APIVolunteerManagerIntegration\Model\Resource\Image;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Employee;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\SignUp;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Spots;

final class VolunteerAssignment
{
    public bool $internal;
    public SignUp $signUp;
    public Employee $employee;
    public Spots $spots;

    public ?string $description = null;
    public ?string $qualifications = null;
    public ?string $schedule = null;
    public ?string $benefits = null;
    public ?Image $featuredImage = null;

    public function __construct(
        SignUp $signUp,
        Spots $spots,
        Employee $employee,
        ?bool $internal = null,
        ?string $description = null,
        ?string $qualifications = null,
        ?string $schedule = null,
        ?string $benefits = null,
        ?Image $featuredImage = null
    ) {
        $this->internal       = $internal ?? false;
        $this->signUp         = $signUp;
        $this->spots          = $spots;
        $this->employee       = $employee;
        $this->description    = $description;
        $this->qualifications = $qualifications;
        $this->schedule       = $schedule;
        $this->benefits       = $benefits;
        $this->featuredImage  = $featuredImage;
    }
}