<?php

namespace APIVolunteerManagerIntegration\Controller\Assignment;

use APIVolunteerManagerIntegration\Helper\WP;
use APIVolunteerManagerIntegration\PostTypes\Assignment;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetField;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use Closure;

class Single
{
    public string $postType = '';
    private ACFGetField $acf;
    private MyPages $myPages;

    public function __construct(
        MyPages $myPages,
        ACFGetField $acf
    ) {
        $this->myPages = $myPages;
        $this->acf     = $acf;

        add_filter("Municipio/Template/{$this->postType()}/single/viewData", [$this, 'controller']);
        add_filter('the_content', [$this, 'replaceContentWithContentPieces'], 10, 1);
    }

    public function postType(): string
    {
        return Assignment::$postType;
    }

    public function replaceContentWithContentPieces(string $content): string
    {
        if ( ! is_singular($this->postType())) {
            return $content;
        }

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
                'content' => WP::getPostMeta('description', ''),
            ],
            'requirements'   => [
                'title'   => $wrapInFn('h3', __(
                    'Requirements',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => WP::getPostMeta('qualifications', ''),
            ],
            'benefits'       => [
                'title'   => $wrapInFn('h3', __(
                    'Benefits',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => WP::getPostMeta('benefits', ''),
            ],
            'where_and_when' => [
                'title'   => $wrapInFn('h3', __(
                    'Where and when?',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => WP::getPostMeta('schedule', ''),
            ],
        ];

        return wpautop(array_reduce(
            array_filter(
                array_values($contentPieces),
                fn($i) => ! empty($i['content'])
            ),
            fn(string $str, array $i) => $str.$i['title'].$i['content'],
            ''
        ));
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

    public function controller(array $data): array
    {
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


        $data['volunteerAssignmentViewModel'] = [
            'signUp'     => $this->extractSignUp(),
            'modal'      => $this->extractModal(),
            'contact'    => $this->extractContact(),
            'signUpForm' => $this->extractSignUpForm(),
            'employer'   => $this->extractEmployer(),
        ];

        return $data;
    }

    function extractSignUp(): array
    {

        $maybeWith =
            fn(bool $condition, Closure $cb) => fn(array $arr): array => $condition
                ? $cb($arr)
                : $arr;

        $withLink =
            fn(array $arr): array => $maybeWith(
                ! empty(WP::getPostMeta('signup_link', '')) && empty($arr),
                fn(array $arr) => array_merge($arr, [
                    'instructions' => 'Välkommen med din intresseanmälan, du anmäler dig via länken nedan.',
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
                'instructions'  => __('Välkommen med din intresseanmälan, du anmäler dig via kontaktuppgifterna nedan.',
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
                'instructions' => 'Välkommen med din intresseanmälan, logga in som volontär för att anmäla dig till detta uppdrag.',
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
                    'Anmälan',
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

    private function extractModal(): array
    {
        if (empty(WP::getPostMeta('internal_assignment', null))) {
            return [];
        }

        return [
            'heading' => __('Logga in som volontär', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
            'id'      => 'assignment-modal-'.(string) (get_queried_object_id()),
            'buttons' => [
                [
                    'text'      => __('Logga in som volontär', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                    'href'      => $this->myPages->loginUrl(get_permalink().'?'.http_build_query(['sign_up' => WP::getPostMeta('uuid')])),
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

    function extractContact(): array
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

    private function extractSignUpForm(): array
    {
        $post = get_queried_object();

        if (empty(WP::getPostMeta('internal_assignment')) || empty($_GET['sign_up']) || (int) $_GET['sign_up'] !== (int) WP::getPostMeta('uuid')) {
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

    private function extractEmployer()
    {
        return [
            'title'        => __(
                'Om uppdragsgivaren',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'instructions' => WP::getPostMeta('employer_about', ''),
            'employer'     => array_filter([
                'name'    => WP::getPostMeta('employer_name', ''),
                'website' => WP::getPostMeta('employer_website', ''),
            ], fn($str) => ! empty($str)),
        ];
    }
}