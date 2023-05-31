<?php

namespace APIVolunteerManagerIntegration\Tests\Virtual\PostType\Controller\Assignment;

use APIVolunteerManagerIntegration\Model\Resource\Image;
use APIVolunteerManagerIntegration\Model\VolunteerAssignment;
use APIVolunteerManagerIntegration\Tests\_TestUtils\PluginTestCase;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\PostType\Controller\Assignment\Archive;
use Mockery;


class ArchiveTest extends PluginTestCase
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

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => $wpQuery->posts,
        ]);

        self::assertArrayHasKey('posts', $data);
        self::assertNotEmpty($data['posts']);
        self::assertNotNull($data['posts'][0]->thumbnail ?? null);
    }

    public function testBreadCrumbs(): void
    {
        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => Mockery::mock(VolunteerAssignment::class),
        ]);

        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => $wpQuery->posts,
        ]);

        self::assertNotEmpty($data['exampleThemeControllerData'], 'Does not remove theme controller data');
        self::assertArrayHasKey('breadcrumbItems', $data);
        self::assertNotEmpty($data['breadcrumbItems']);
        self::assertGreaterThan(1, count($data['breadcrumbItems']));
    }

    public function testCurrentBreadcrumbItemIsPostTypeArchive(): void
    {
        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => Mockery::mock(VolunteerAssignment::class),
        ]);

        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => $wpQuery->posts,
        ]);

        $currentItem = array_values(
            array_filter(
                $data['breadcrumbItems'],
                fn(array $i) => ! empty($i['current'])
            )
        );

        $postTypeObject = $wp->getPostTypeObject($post->post_type);

        self::assertCount(1, $currentItem);
        self::assertEquals($postTypeObject ? $postTypeObject->label : false, $currentItem[0]['label']);
        self::assertStringContainsString($wp->homeUrl(), $currentItem[0]['href']);
        self::assertStringContainsString($wp->getPostTypeArchiveLink($post->post_type),
            $currentItem[0]['href']
        );
    }

    public function testFeaturedImage(): void
    {
        $model                = Mockery::mock(VolunteerAssignment::class);
        $model->featuredImage = new Image(
            -6575,
            'image/jpeg',
            'featured-image.jpg',
            'https://remote-service/uploads/featured-image.jpg',
            'Some alt text',
            800,
            600,
        );

        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => $model,
        ]);


        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => $wpQuery->posts,
        ]);

        self::assertArrayHasKey('posts', $data);
        self::assertNotEmpty($data['posts']);
        self::assertNotEmpty($data['posts'][0]->thumbnail);

        self::assertArrayHasKey('src', $data['posts'][0]->thumbnail);
        self::assertArrayHasKey('alt', $data['posts'][0]->thumbnail);
        self::assertArrayHasKey('title', $data['posts'][0]->thumbnail);

        self::assertNotEmpty($data['posts'][0]->thumbnail['src']);
        self::assertNotEmpty($data['posts'][0]->thumbnail['alt']);
        self::assertNotEmpty($data['posts'][0]->thumbnail['title']);

        self::assertIsString($data['posts'][0]->thumbnail['src']);
        self::assertIsString($data['posts'][0]->thumbnail['alt']);
        self::assertIsString($data['posts'][0]->thumbnail['title']);
    }


    public function testNoPosts(): void
    {
        $wp      = $this->createFakeWpService();
        $wpQuery = $this->createFakeWpQuery(['post_type' => Assignment::POST_TYPE]);

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => [],
        ]);

        self::assertArrayHasKey('posts', $data);
        self::assertEmpty($data['posts']);
        self::assertIsArray($data['posts']);
    }

    public function testNoFeaturedImage(): void
    {
        $wp   = $this->createFakeWpService();
        $post = $this->createFakePost([
            'post_title' => 'Fake Assignment',
            'post_name'  => 'fake-assignment',
            'post_type'  => Assignment::POST_TYPE,
            'model'      => Mockery::mock(VolunteerAssignment::class),
        ]);


        $wpQuery = $this->createFakeWpQuery([], $post);

        $data = (new Archive($wp, $wp, $wp))->archive([
            'wpQuery' => $wpQuery, 'exampleThemeControllerData' => true,
            'posts'   => $wpQuery->posts,
        ]);

        self::assertArrayHasKey('posts', $data);
        self::assertNotEmpty($data['posts']);
        self::assertNotEmpty($data['posts'][0]->thumbnail);

        self::assertArrayHasKey('src', $data['posts'][0]->thumbnail);
        self::assertArrayHasKey('alt', $data['posts'][0]->thumbnail);
        self::assertArrayHasKey('title', $data['posts'][0]->thumbnail);


        self::assertNotEmpty($data['posts'][0]->thumbnail['title']);

        self::assertNull($data['posts'][0]->thumbnail['src']);
        self::assertNull($data['posts'][0]->thumbnail['alt']);
        self::assertIsString($data['posts'][0]->thumbnail['title']);
    }
}