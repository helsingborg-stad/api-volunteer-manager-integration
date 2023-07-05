<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Model\Generic\Collection;
use APIVolunteerManagerIntegration\Model\Resource\Image;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment\Contact;
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
            'content'  => $this->createPostContent($meta ?? []),
            'excerpt'  => $meta['description'] ?? '',
            'created'  => $created,
            'modified' => $modified,
            'model'    => $this->createModel($meta ?? [], $_embedded ?? []),
        ]);
    }

    public function createPostContent(array $data): string
    {
        $wrapInFn = fn(
            string $tag,
            string $str,
            ?string $attributes = ''
        ): string => "<$tag $attributes>".$str."</$tag>";

        $contentPieces = [
            'about'          => [
                'title'   => $wrapInFn('h2', __(
                    'About the assignment',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ), 'class="u-margin__top--0"'),
                'content' => $data['description'] ?? '',
            ],
            'requirements'   => [
                'title'   => $wrapInFn('h3', __(
                    'Requirements',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => $data['qualifications'] ?? '',
            ],
            'benefits'       => [
                'title'   => $wrapInFn('h3', __(
                    'Benefits',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => $data['benefits'] ?? '',
            ],
            'where_and_when' => [
                'title'   => $wrapInFn('h3', __(
                    'Where and when?',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => $data['schedule'] ?? '',
            ],
        ];

        return array_reduce(
            array_filter(
                array_values($contentPieces),
                fn($i) => ! empty($i['content'])
            ),
            fn(string $str, array $i) => $str.$i['title'].$i['content'],
            ''
        );
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
                empty($meta['internal_assignment']) ? [
                    ...($meta['signup_link'] ? ['link'] : []),
                    ...(empty($meta['signup_link']) && ! empty($meta['signup_email']) ? ['email'] : []),
                    ...(empty($meta['signup_link']) && ! empty(($meta['signup_phone'])) ? ['phone'] : []),
                ] : [],
                $meta['signup_email'] ?? '',
                $meta['signup_link'] ?? '',
                $meta['signup_phone'] ?? '',
            ),
            new VolunteerAssignment\Spots(
                (int) ($meta['number_of_available_spots'] ?? 0)
            ),
            new VolunteerAssignment\Employer(
                $meta['employer_name'] ?? '',
                $meta['employer_website'] ?? '',
                new Collection($this->parseEmployeeContacts(is_array($meta['employer_contacts']) ? $meta['employer_contacts'] : [])),
                $meta['employer_about'] ?? '',
            ),
            $meta['internal_assignment'] ?? null,
            $meta['description'] ?? null,
            $meta['qualifications'] ?? null,
            $meta['schedule'] ?? null,
            $meta['benefits'] ?? null,
            $this->getFeaturedMediaFromEmbedded($embedded),
            $this->parseEmployeeContacts(is_array($meta['employer_contacts']) ? $meta['employer_contacts'] : [])[0] ?? null,
            $meta['where'] ?? null,
            $meta['when'] ?? null,
            $meta['read_more_link'] ?? null,
        );
    }

    /**
     * @param  array  $data
     *
     * @return Contact[]
     */
    public function parseEmployeeContacts(array $data): array
    {
        $contacts = array_values(
            array_filter(
                $data,
                fn(array $item) => ! empty($item['phone']) || ! empty($item['email'])
            )
        );

        return array_map(
            fn(array $contact) => new Contact(
                $contact['name'] ?? '',
                $contact['email'] ?? '',
                $contact['phone'] ?? ''
            ),
            $contacts
        );
    }

    function getFeaturedMediaFromEmbedded(array $embedded): ?Image
    {
        if ( ! empty($embedded) && ! empty($embedded['wp:featuredmedia'][0])) {
            return $this->createImageFromMedia($embedded['wp:featuredmedia'][0]);
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
