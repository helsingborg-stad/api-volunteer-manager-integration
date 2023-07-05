<?php
declare(strict_types=1);

namespace APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetField;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeArchiveLink;
use APIVolunteerManagerIntegration\Services\WPService\GetPostTypeObject;
use APIVolunteerManagerIntegration\Services\WPService\HomeUrl;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Controller\VQSingleController;
use Closure;
use WP_Post;
use WP_Query;

class Single extends VQSingleController
{
    public string $postType = '';
    private HomeUrl $homeUrl;
    private GetPostTypeObject $getPostTypeObject;
    private GetPostTypeArchiveLink $getPostTypeArchiveLink;
    private ACFGetField $acf;
    private MyPages $myPages;

    public function __construct(
        HomeUrl $homeUrl,
        GetPostTypeObject $getPostTypeObject,
        GetPostTypeArchiveLink $getPostTypeArchiveLink,
        MyPages $myPages,
        ACFGetField $acf
    ) {
        $this->homeUrl                = $homeUrl;
        $this->getPostTypeObject      = $getPostTypeObject;
        $this->getPostTypeArchiveLink = $getPostTypeArchiveLink;
        $this->myPages                = $myPages;
        $this->acf                    = $acf;
    }

    function single(array $data): array
    {
        $model = $this->getModel($data['wpQuery']);

        if ( ! $model) {
            $data['volunteerAssignment'] = null;

            return $data;
        }

        $data['rightColumnSize']   = 5;
        $data['featuredThumbnail'] = $this->featuredImage($model);
        $data['breadcrumbItems']   = $this->breadcrumbs($data['wpQuery']);

        $data['volunteerAssignmentLabels'] = [
            'sign_up'     => __(
                'Sign up',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'sign_up_c2a' => __(
                'Sign up',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'contact_us'  => __(
                'Contact',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
        ];

        $data['volunteerAssignment'] = $model;

        $data['volunteerAssignmentViewModel'] = [
            'signUp'     => $this->extractSignUp($model, $data['wpQuery']->posts[0]),
            'contact'    => $this->extractContact($model),
            'modal'      => $this->extractModal($model, $data['wpQuery']->posts[0]),
            'signUpForm' => $this->extractSignUpForm($model, $data['wpQuery']->posts[0]),
            'employer'   => $this->extractEmployer($model),
        ];

        return $data;
    }

    function getModel(?WP_Query $wpQuery): ?VolunteerAssignment
    {
        return $wpQuery && isset($wpQuery->post->model) && $wpQuery->post->model instanceof VolunteerAssignment
            ? $wpQuery->post->model
            : null;
    }

    function featuredImage(VolunteerAssignment $model): object
    {
        return (object) [
            'id'    => $model->featuredImage->id ?? 0,
            'src'   => ! empty($model->featuredImage->source) ? [$model->featuredImage->source] : [],
            'alt'   => $model->featuredImage->altText ?? '',
            'title' => $model->featuredImage->fileName ?? '',
        ];
    }

    private function breadcrumbs(WP_Query $wpQuery): array
    {
        return [
            [
                'label'   => __('Home', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'href'    => $this->homeUrl->homeUrl(),
                'current' => false,
                'icon'    => 'home',
            ],
            [
                'label'   => $this->getPostTypeObject->getPostTypeObject($wpQuery->get('post_type'))->label ?? '',
                'href'    => $this->getPostTypeArchiveLink->getPostTypeArchiveLink($wpQuery->get('post_type')),
                'current' => false,
                'icon'    => 'chevron_right',
            ],
            [
                'label'   => $wpQuery->post->post_title ?? $wpQuery->get('name'),
                'href'    => $this->getPostTypeArchiveLink->getPostTypeArchiveLink($wpQuery->get('post_type')).$wpQuery->get('name').'/',
                'current' => true,
                'icon'    => 'chevron_right',
            ],
        ];
    }

    function extractSignUp(VolunteerAssignment $assignment, WP_Post $post): array
    {
        $maybeWith =
            fn(bool $condition, Closure $cb) => fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;

        $withLink =
            fn(array $arr): array => $maybeWith(
                in_array('link', $assignment->signUp->methods) && empty($arr),
                fn(array $arr) => array_merge($arr, [
                    'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                    'signUpUrl'    => [
                        'url'   => $assignment->signUp->link,
                        'label' => __(
                            'Sign up',
                            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                        ),
                    ],
                ]))($arr);


        $withContact = fn(array $arr): array => $maybeWith(
            (in_array('email', $assignment->signUp->methods) || in_array('phone',
                    $assignment->signUp->methods)) && empty($arr),
            fn(array $arr) => array_merge($arr, [
                'instructions'  => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'signUpContact' => array_filter([
                    'person' => '',
                    'email'  => $assignment->signUp->email,
                    'phone'  => $assignment->signUp->phone,
                ], fn($str) => ! empty($str)),
            ])
        )($arr);

        $withInternalUrl = fn(array $arr): array => $maybeWith(
            $assignment->internal === true && empty($arr),
            fn(array $arr) => array_merge($arr, [
                'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'signUpButton' => [
                    'modalId' => 'assignment-modal-'.(string) ($post->ID ?? ''),
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
                    'Sign up',
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

    function extractContact(VolunteerAssignment $model): array
    {
        $maybeWith =
            fn(bool $condition, Closure $cb) => fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;

        $withContact = fn(array $arr): array => $maybeWith(
            ! empty($model->employer->contacts) && ! empty($model->employer->contacts[0]),
            fn(array $arr) => array_merge($arr, [
                'contact' => array_filter([
                    'person' => $model->employer->contacts[0]->name,
                    'email'  => $model->employer->contacts[0]->email,
                    'phone'  => $model->employer->contacts[0]->phone,
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

    private function extractModal(VolunteerAssignment $model, WP_Post $post): array
    {
        if (empty($model->internal)) {
            return [];
        }

        return [
            'heading' => __('Sign up for', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN).': '.$post->post_title,
            'id'      => 'assignment-modal-'.(string) ($post->ID ?? ''),
            'buttons' => [
                [
                    'text'      => __('Logga in som volontär', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'href'      => $this->myPages->loginUrl(get_permalink().'?'.http_build_query(['sign_up' => $post->ID])),
                    'color'     => 'primary',
                    'style'     => 'filled',
                    'fullWidth' => true,
                ],
                [
                    'text'      => __('Registrera dig som volontär', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'href'      => $this->acf->getField('volunteer_manager_integration_volunteer_registration_page',
                            'options')['url'] ?? '#',
                    'color'     => 'primary',
                    'style'     => 'basic',
                    'fullWidth' => true,
                ],
            ],
        ];
    }

    private function extractSignUpForm(VolunteerAssignment $model, WP_Post $post): array
    {
        if (empty($model->internal) || empty($_GET['sign_up']) || (int) $_GET['sign_up'] !== $post->ID) {
            return [];
        }

        return [
            'heading'            => $post->post_title,
            'id'                 => 'assignment-sign-up-modal-'.(string) ($post->ID ?? ''),
            'volunteerApiUri'    => get_field('volunteer_manager_integration_api_uri', 'options'),
            'volunteerAppSecret' => get_field('volunteer_manager_integration_app_secret', 'options'),
            'labels'             => [],
            'signOutUrl'         => $this->myPages->signOutUrl(),
        ];
    }

    private function extractEmployer(VolunteerAssignment $model)
    {
        return [
            'title'        => __(
                'Om uppdragsgivaren',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'instructions' => $model->employer->about ?? '',
            'employer'     => array_filter([
                'name'    => '<b>Förening:</b> '.$model->employer->name,
                'website' => '<b>Hemsida:</b> '.$model->employer->website,
            ], fn($str) => ! empty($str)),
        ];
    }
}