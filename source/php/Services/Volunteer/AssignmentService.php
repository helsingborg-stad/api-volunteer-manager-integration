<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Model\Generic\Collection;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Services\Volunteer\WpRestAdapter\PostsAdapter;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\VirtualPostFactory;
use WP_Post;

class AssignmentService extends PostsAdapter implements VQPosts
{
    public const TYPE = 'assignment';

    /**
     * @param  array  $data
     *
     * @return WP_Post
     */
    public function toPost(array $data): WP_Post
    {
        extract($data);

        return VirtualPostFactory::create([
            'id'       => $id,
            'title'    => $title,
            'slug'     => $slug,
            'type'     => Assignment::POST_TYPE,
            'content'  => $meta['description'] ?? '',
            'created'  => $created,
            'modified' => $modified,
            'model'    => $this->createModel($meta),
        ]);
    }


    /**
     * @param  array  $meta
     *
     * @return VolunteerAssignment
     */
    public function createModel(array $meta): VolunteerAssignment
    {
        return new VolunteerAssignment(
            new VolunteerAssignment\SignUp(
                $meta['signup_methods'] ?? [],
                $meta['signup_email'] ?? '',
                $meta['signup_link'] ?? '',
                $meta['signup_phone'] ?? '',
            ),
            new VolunteerAssignment\Spots(
                (int) ($meta['number_of_available_spots'] ?? 0)
            ),
            new VolunteerAssignment\Employee(
                $meta['employer_name'] ?? '',
                $meta['employer_website'] ?? '',
                new Collection($this->parseEmployeeContacts($meta['employer_contacts']))
            ),
            $meta['internal_assignment'] ?? false,
            $meta['description'] ?? '',
            $meta['qualifications'] ?? '',
            $meta['schedule'] ?? '',
            $meta['benefits'] ?? '',

        );
    }

    /**
     * @param  array  $data
     *
     * @return VolunteerAssignment\Employee\Contact[]
     */
    public function parseEmployeeContacts(array $data): array
    {
        $contacts = array_values(
            array_filter(
                $data,
                fn(array $item) => ! empty($item['name']) && ! empty($item['phone']) && ! empty($item['email'])
            )
        );

        return array_map(
            fn(array $contact) => new VolunteerAssignment\Employee\Contact(
                $contact['name'],
                $contact['email'],
                $contact['phone']
            ),
            $contacts
        );
    }
}
