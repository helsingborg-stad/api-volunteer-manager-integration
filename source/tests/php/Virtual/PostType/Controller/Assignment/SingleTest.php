<?php

namespace APIVolunteerManagerIntegration\Tests\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Tests\_TestUtils\PluginTestCase;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Single;


class SingleTest extends PluginTestCase
{
    public function testNoModel(): void
    {
        $wp      = $this->createFakeWpService();
        $post    = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
        ]);
        $wpQuery = $this->createFakeWpQuery([], $post);


        $controller = new Single($wp, $wp, $wp);
        $data       = $controller->single(['wpQuery' => $wpQuery, 'exampleThemeControllerData' => true]);

        self::assertArrayHasKey('volunteerAssignment', $data, 'model property exists');
        self::assertNull($data['volunteerAssignment'], 'model property always allows null coalescing operator');
        self::assertNotEmpty($data['exampleThemeControllerData'], 'does not remove theme controller data');
    }


    public function testBreadCrumbs(): void
    {
        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => new VolunteerAssignment(
                new VolunteerAssignment\SignUp([], '', '', ''),
                $this->prophesize(VolunteerAssignment\Spots::class)->reveal(),
                $this->prophesize(VolunteerAssignment\Employee::class)->reveal(),
                null,
                '',
                '',
                '',
                '',
                null,
                null,
                null,
                null,
                null,
            ),
        ]);

        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Single($wp, $wp, $wp))->single([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
        ]);

        self::assertNotEmpty($data['exampleThemeControllerData'], 'Does not remove theme controller data');
        self::assertArrayHasKey('breadcrumbItems', $data);
        self::assertNotEmpty($data['breadcrumbItems']);
        self::assertGreaterThan(2, count($data['breadcrumbItems']));
    }

    public function testCurrentBreadCrumbItem(): void
    {
        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => new VolunteerAssignment(
                new VolunteerAssignment\SignUp([], '', '', ''),
                $this->prophesize(VolunteerAssignment\Spots::class)->reveal(),
                $this->prophesize(VolunteerAssignment\Employee::class)->reveal(),
                null,
                '',
                '',
                '',
                '',
                null,
                null,
                null,
                null,
                null,
            ),
        ]);

        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Single($wp, $wp, $wp))->single([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
        ]);

        $currentItem = array_values(
            array_filter(
                $data['breadcrumbItems'],
                fn(array $i) => ! empty($i['current'])
            )
        );

        self::assertCount(1, $currentItem);
        self::assertEquals($post->post_title, $currentItem[0]['label']);
        self::assertStringContainsString($wp->homeUrl(), $currentItem[0]['href']);
        self::assertStringContainsString($post->post_name, $currentItem[0]['href']);
        self::assertStringContainsString($wp->getPostTypeArchiveLink($post->post_type),
            $currentItem[0]['href']
        );
    }
}