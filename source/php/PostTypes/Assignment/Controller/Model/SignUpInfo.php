<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\PhoneNumber;
use APIVolunteerManagerIntegration\Helper\WP;
use Closure;

class SignUpInfo
{

    public function data(): array
    {
        $withLink =
            fn(array $arr): array => self::maybeWith(
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

        $withContact = fn(array $arr): array => self::maybeWith(
            empty($arr),
            fn(array $arr) => array_merge($arr, [
                'instructions'  => __('Welcome with your expression of interest, you can apply using the contact details below.',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'signUpContact' => array_filter([
                    [
                        'value' => WP::getPostMeta('signup_email',
                            ''),
                        'icon'  => 'email',
                        'link'  => implode('', [
                            "mailto:",
                            WP::getPostMeta('signup_email', ''),
                            '?',
                            http_build_query(
                                [
                                    'subject' => __("Sign up for volunteer assignment",
                                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).': '.get_the_title(),
                                    'body'    => __("Hello, I want to get in touch and learn more.",
                                        API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                                ],
                                "",
                                '&',
                                PHP_QUERY_RFC3986
                            ),
                        ]),
                    ],
                    [
                        'value' => (new PhoneNumber(WP::getPostMeta('signup_phone', '')))->toHumanReadable(),
                        'icon'  => 'phone',
                        'link'  => (new PhoneNumber(WP::getPostMeta('signup_phone', '')))->toUri(),
                    ],
                ], fn($str) => ! empty(trim($str['value']))),
            ])
        )($arr);

        $withInternalUrl = fn(array $arr): array => self::maybeWith(
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

        $createSignUpData = fn(array $arr): array => self::maybeWith(
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

    private static function maybeWith(bool $condition, Closure $cb)
    {
        return fn(array $arr): array => $condition
            ? $cb($arr)
            : $arr;
    }

}