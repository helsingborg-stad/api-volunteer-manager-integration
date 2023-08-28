<?php

namespace APIVolunteerManagerIntegration\Import;

class Assignment extends Importer
{
    public $postType = 'vol-assignment';

    public function init()
    {
    }

    public function mapTaxonomies($post)
    {
        $data = [
            'volunteer_assignment_category' => $post['meta']['assignment_category'] ? [$post['meta']['assignment_category']] : null,
        ];

        $this->taxonomies = array_keys($data);

        return $data;
    }

    public function mapMetaKeys($post)
    {
        extract($post);

        $data = [
            'uuid'                      => $post['id'] ?? null,
            'last_modified'             => $post['modified'] ?? null,
            'employer_name'             => $post['meta']['employer_name'] ?? null,
            'employer_about'            => $post['meta']['employer_about'] ?? null,
            'employer_website'          => $post['meta']['employer_website'] ?? null,
            'employer_contacts'         => $post['meta']['employer_contacts'] ?? null,
            'internal_assignment'       => $post['meta']['internal_assignment'] ?? null,
            'signup_email'              => $post['meta']['signup_email'] ?? null,
            'signup_phone'              => $post['meta']['signup_phone'] ?? null,
            'signup_link'               => $post['meta']['signup_link'] ?? null,
            'description'               => $post['meta']['description'] ?? null,
            'qualifications'            => $post['meta']['qualifications'] ?? null,
            'schedule'                  => $post['meta']['schedule'] ?? null,
            'benefits'                  => $post['meta']['benefits'] ?? null,
            'number_of_available_spots' => $post['meta']['number_of_available_spots'] ?? null,
            'street_address'            => $post['meta']['street_address'] ?? null,
            'postal_code'               => $post['meta']['postal_code'] ?? null,
            'city'                      => $post['meta']['city'] ?? null,
        ];

        return $data;
    }
}
