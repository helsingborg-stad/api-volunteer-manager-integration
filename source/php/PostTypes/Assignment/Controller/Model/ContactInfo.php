<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;
use Closure;

class ContactInfo
{
    function data(): array
    {
        $contacts = WP::getPostMeta('employer_contacts', []);

        $maybeWith =
            fn(bool $condition, Closure $cb) => fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;


        $withContact = fn(array $arr): array => $maybeWith(
            ! empty($contacts),
            fn(array $arr) => array_merge($arr, [
                'contact' => array_filter([
                    'person' => $contacts[0]['name'],
                    'email'  => $contacts[0]['email'],
                    'phone'  => $contacts[0]['phone'],
                ], fn($str) => ! empty($str)),
            ])
        )($arr);

        $createContactData = fn(array $arr): array => $maybeWith(
            ! empty($arr),
            fn(array $arr) => array_merge($arr, [
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