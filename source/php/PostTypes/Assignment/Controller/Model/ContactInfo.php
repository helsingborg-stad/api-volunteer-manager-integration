<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;

class ContactInfo
{
    public function data(): array
    {
        $contacts = WP::getPostMeta('employer_contacts', []);

        $maybeWith =
            static fn(bool $condition, callable $cb) => static fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;

        $withContact = static fn(array $arr): array => $maybeWith(
            ! empty($contacts),
            static fn(array $arr) => array_merge($arr, [
                'contact' => array_filter([
                    [
                        'value' => $contacts[0]['name'],
                        'icon'  => 'person',
                    ],
                    [
                        'value' => $contacts[0]['email'],
                        'icon'  => 'email',
                    ],
                    [
                        'value' => $contacts[0]['phone'],
                        'icon'  => 'phone',
                    ],
                ], static fn($str) => ! empty($str['value'])),
            ])
        )($arr);

        $createContactData = static fn(array $arr): array => $maybeWith(
            ! empty($arr),
            static fn(array $arr) => array_merge($arr, [
                'title' => __(
                    'Contact',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ),
            ])
        )($arr);

        return $createContactData(
            $withContact(
                []
            )
        );
    }
}