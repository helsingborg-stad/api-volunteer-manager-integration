<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Model\Generic\Collection;
use APIVolunteerManagerIntegration\Model\Resource\Image;
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
            'model'    => $this->createModel($meta, $_embedded ?? []),
        ]);
    }

    /**
     * @param  array  $meta
     * @param  array  $embedded
     *
     * @return VolunteerAssignment
     */
    public function createModel(array $meta, array $embedded): VolunteerAssignment
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
            $meta['internal_assignment'] ?? null,
            $meta['description'] ?? null,
            $meta['qualifications'] ?? null,
            $meta['schedule'] ?? null,
            $meta['benefits'] ?? null,
            $this->getFeaturedMediaFromEmbedded($embedded)
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

    function getFeaturedMediaFromEmbedded(array $embedded): ?Image
    {
        if ( ! empty($embedded) && ! empty($embedded['wp:featuredmedia'][0])) {
            return $this->createImageFromMedia($embedded['wp:featuredmedia'][0], 'full');
        }

        return null;
    }

    function createImageFromMedia(array $media, string $size = 'full'): Image
    {
        return empty($media['media_details']['sizes'][$size]) ? new Image(
            $media['id'],
            $media['media_details']['mime_type'] ?? '',
            $media['media_details']['file'] ?? '',
            $media['source_url'],
            $media['alt_text'] ?? '',
            $media['media_details']['width'],
            $media['media_details']['height'],
        ) : new Image(
            $media['id'],
            $media['media_details']['sizes'][$size]['mime_type'] ?? '',
            $media['media_details']['sizes'][$size]['file'] ?? '',
            $media['media_details']['sizes'][$size]['source_url'],
            $media['alt_text'] ?? '',
            $media['media_details']['sizes'][$size]['width'],
            $media['media_details']['sizes'][$size]['height'],
        );

    }
}
