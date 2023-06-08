<?php

namespace APIVolunteerManagerIntegration\Model;

use APIVolunteerManagerIntegration\Model\Resource\Image;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Contact;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Employer;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\SignUp;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Spots;

class VolunteerAssignment
{
    public bool $internal;
    public SignUp $signUp;
    public Employer $employer;
    public Spots $spots;

    public ?string $description = null;
    public ?string $qualifications = null;
    public ?string $schedule = null;
    public ?string $benefits = null;
    public ?Image $featuredImage = null;
    public ?Contact $publicContact;
    public ?string $where;
    public ?string $when;
    public ?string $readMoreLink;

    public function __construct(
        SignUp $signUp,
        Spots $spots,
        Employer $employer,
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
        $this->employer       = $employer;
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