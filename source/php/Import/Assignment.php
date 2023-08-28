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
            'employer_name'             => $post['employer_name'] ?? null,
            'employer_about'            => $post['employer_about'] ?? null,
            'employer_website'          => $post['employer_website'] ?? null,
            'internal_assignment'       => $post['internal_assignment'] ?? null,
            'signup_email'              => $post['signup_email'] ?? null,
            'signup_phone'              => $post['signup_phone'] ?? null,
            'signup_link'               => $post['signup_link'] ?? null,
            'description'               => $post['description'] ?? null,
            'qualifications'            => $post['qualifications'] ?? null,
            'schedule'                  => $post['schedule'] ?? null,
            'benefits'                  => $post['benefits'] ?? null,
            'number_of_available_spots' => $post['number_of_available_spots'] ?? null,
            'street_address'            => $post['street_address'] ?? null,
            'postal_code'               => $post['postal_code'] ?? null,
            'city'                      => $post['city'] ?? null,
        ];

        return $data;
    }
}
