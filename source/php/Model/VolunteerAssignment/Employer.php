<?php

namespace APIVolunteerManagerIntegration\Model\VolunteerAssignment;

use APIVolunteerManagerIntegration\Model\Generic\Collection;

class Employer
{
    public string $name;

    public string $website;

    /**
     * @var Collection<Contact>
     */
    public Collection $contacts;

    /**
     * @param  string  $name
     * @param  string  $website
     * @param  Collection<Contact>  $contacts
     */
    public function __construct(
        string $name,
        string $website,
        Collection $contacts
    ) {
        $this->name     = $name;
        $this->website  = $website;
        $this->contacts = $contacts;
    }
}