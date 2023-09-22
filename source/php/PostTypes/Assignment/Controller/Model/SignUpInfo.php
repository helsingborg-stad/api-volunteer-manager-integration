<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;
use Closure;

class SignUpInfo
{
    public function data(): array
    {
        $maybeWith =
            fn(bool $condition, Closure $cb) => fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;

        $withLink =
            fn(array $arr): array => $maybeWith(
                ! empty(WP::getPostMeta('signup_link', '')) && empty($arr),
                fn(array $arr) => array_merge($arr, [
                    'instructions' => __('Welcome with your expression of interest, you can apply through the link below.',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'signUpUrl'    => [
                        'url'   => WP::getPostMeta('signup_link', ''),
                        'label' => __(
                            'Sign up',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                        ),
                    ],
                ]))($arr);


        $withContact = fn(array $arr): array => $maybeWith(
            ( ! empty(WP::getPostMeta('signup_email', null)) || ! empty(WP::getPostMeta('signup_phone',
                    null))) && empty($arr),
            fn(array $arr) => array_merge($arr, [
                'instructions'  => __('Welcome with your expression of interest, you can apply using the contact details below.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'signUpContact' => array_filter([
                    'person' => '',
                    'email'  => WP::getPostMeta('signup_email', ''),
                    'phone'  => WP::getPostMeta('signup_phone', ''),
                ], fn($str) => ! empty($str)),
            ])
        )($arr);

        $withInternalUrl = fn(array $arr): array => $maybeWith(
            WP::getPostMeta('internal_assignment', null) && empty($arr),
            fn(array $arr) => array_merge($arr, [
                'instructions' => __('Welcome with your expression of interest, login or register a volunteer account using the link below.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'signUpButton' => [
                    'modalId' => 'assignment-modal-'.(string) (get_queried_object_id() ?? ''),
                    'label'   => __(
                        'Sign up',
                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                    ),
                    '',
                ],
            ])
        )($arr);

        $createSignUpData = fn(array $arr): array => $maybeWith(
            ! empty($arr),
            fn(array $arr) => array_merge($arr, [
                'title'   => __(
                    'Registration',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                ),
                'dueDate' => '',
            ])
        )($arr);

        return $createSignUpData(
            $withContact(
                $withLink(
                    $withInternalUrl(
                        []
                    )
                )
            )
        );
    }
}