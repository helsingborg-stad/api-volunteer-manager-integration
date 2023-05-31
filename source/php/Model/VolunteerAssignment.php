<?php

namespace APIVolunteerManagerIntegration\Model;

use APIVolunteerManagerIntegration\Model\Resource\Image;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Contact;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Employee;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\SignUp;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Spots;

class VolunteerAssignment
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
    private ?Contact $publicContact;
    private ?string $where;
    private ?string $when;
    private ?string $readMoreLink;

    public function __construct(
        SignUp $signUp,
        Spots $spots,
        Employee $employee,
        ?bool $internal = null,
        ?string $description = null,
        ?string $qualifications = null,
        ?string $schedule = null,
        ?string $benefits = null,
        ?Image $featuredImage = null,
        ?Contact $publicContact = null,
        ?string $where = null,
        ?string $when = null,
        ?string $readMoreLink = null
    ) {
        $this->signUp         = $signUp;
        $this->spots          = $spots;
        $this->employee       = $employee;
        $this->description    = $description;
        $this->qualifications = $qualifications;
        $this->schedule       = $schedule;
        $this->benefits       = $benefits;
        $this->featuredImage  = $featuredImage;
        $this->publicContact  = $publicContact;
        $this->where          = $where;
        $this->when           = $when;
        $this->readMoreLink   = $readMoreLink;
        $this->internal       = $internal ?? false;
    }
}