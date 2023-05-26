<?php

namespace APIVolunteerManagerIntegration\Tests;

use APIVolunteerManagerIntegration\Services\WPService\WPService;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use Brain\Monkey;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use WP_Post;
use WP_Post_Type;
use WP_Query;

class PluginTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Setup which calls \WP_Mock setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
        // A few common pass through
        // 1. WordPress i18n functions.
        Monkey\Functions\when('__')
            ->returnArg();
        Monkey\Functions\when('_e')
            ->returnArg();
        Monkey\Functions\when('_n')
            ->returnArg();
    }

    /**
     * Teardown which calls \WP_Mock tearDown
     *
     * @return void
     */
    public function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function createFakeWpService(?array $args = []): WPService
    {
        $createMockPostTypeObject = fn(
            array $properties,
            WP_Post_Type $initialPostTypeObj
        ): WP_Post_Type => array_reduce(
            array_chunk($properties, 1, true),
            function (WP_Post_Type $postTypeObj, array $i): WP_Post_Type {
                $postTypeObj->{key($i)} = current($i);

                return $postTypeObj;
            },
            $initialPostTypeObj
        );

        $homeUrl   = $args['homeUrl'] ?? $this->homeUrl();
        $postTypes = $args['postTypeObjects'] ?? $this->customPostTypes();

        $wp = Mockery::mock(WPService::class);

        $wp->allows('homeUrl')
           ->withAnyArgs()
           ->andReturnUsing(fn(?string $path = '') => ! empty($path)
               ? rtrim($homeUrl, '/').'/'.ltrim($path, '/')
               : rtrim($homeUrl, '/'));

        $wp->allows('getPostTypeObject')
           ->withAnyArgs()
           ->andReturnUsing(fn(string $postType) => isset($postTypes[$postType])
               ? $createMockPostTypeObject(
                   $postTypes[$postType],
                   Mockery::mock('WP_Post_Type'))
               : null
           );

        $wp->allows('getPostTypeArchiveLink')
           ->withAnyArgs()
           ->andReturnUsing(fn(string $postType) => ! empty($postTypes[$postType])
               ? $wp->homeUrl((! empty($postTypes[$postType]['slug']) ? $postTypes[$postType]['slug'] : $postType).'/')
               : null
           );

        return $wp;
    }

    public function homeUrl(): string
    {
        return 'https://home-url.com';
    }

    public function customPostTypes(): array
    {
        return [
            Assignment::POST_TYPE => [
                'name'   => Assignment::POST_TYPE,
                'label'  => __('Volunteer Assignment', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                'labels' => [],
                'slug'   => Assignment::POST_TYPE,
            ],
        ];
    }

    public function createFakeWpQuery(?array $queryVars, ?WP_post ...$posts): WP_Query
    {
        $queryVars      = $queryVars ?? [];
        $wpQuery        = Mockery::mock('WP_Query');
        $wpQuery->posts = $posts ?? null;
        $wpQuery->post  = $wpQuery->posts[0] ?? null;

        if ($wpQuery->post) {
            $queryVars['name']      = $wpQuery->post->post_name;
            $queryVars['post_type'] = $wpQuery->post->post_type;
        }

        foreach ($queryVars as $key => $value) {
            $wpQuery->shouldReceive('get')
                    ->with($key)
                    ->andReturn($value);
        }

        return $wpQuery;
    }

    public function createFakePost($args): WP_Post
    {
        $post = Mockery::mock('WP_Post');

        foreach ($args as $key => $value) {
            $post->{$key} = $value;
        }

        return $post;
    }
}
