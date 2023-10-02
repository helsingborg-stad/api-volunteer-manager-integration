<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller;

use APIVolunteerManagerIntegration\Helper\WP;
use APIVolunteerManagerIntegration\PostTypes\Assignment;
use APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model\ContactInfo;
use APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model\EmployerInfo;
use APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model\LoginModal;
use APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model\SignUpInfo;
use APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model\SignUpModal;
use APIVolunteerManagerIntegration\Services\ACFService\ACFGetField;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;

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
                'content' => trim(WP::getPostMeta('description', '')),
            ],
            'requirements'   => [
                'title'   => $wrapInFn('h3', __(
                    'Requirements',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => trim(WP::getPostMeta('qualifications', '')),
            ],
            'benefits'       => [
                'title'   => $wrapInFn('h3', __(
                    'Benefits',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => trim(WP::getPostMeta('benefits', '')),
            ],
            'where_and_when' => [
                'title'   => $wrapInFn('h3', __(
                    'Where and when?',
                    API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
                )),
                'content' => trim(WP::getPostMeta('schedule', '')),
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

    public function controller(array $data): array
    {
        $data['volunteerAssignmentViewModel'] = [
            'signUpInfo'   => (new SignUpInfo())->data(),
            'signUpModal'  => (new SignUpModal($this->myPages, $this->acf))->data(),
            'loginModal'   => (new LoginModal($this->myPages, $this->acf))->data(),
            'contactInfo'  => (new ContactInfo())->data(),
            'employerInfo' => (new EmployerInfo())->data(),
        ];

        return $data;
    }
}