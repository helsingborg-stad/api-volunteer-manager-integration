<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

use WP_Post_Type;

class WPServiceFactory
{
    public static function create(): WPService
    {
        return new class implements WPService {
            public function wpGetNavMenuItems($menu, array $args = []): ?array
            {
                return wp_get_nav_menu_items($menu, $args) ?: null;
            }

            public function getNavMenuLocations(): array
            {
                return get_nav_menu_locations();
            }

            public function registerNavMenu($location, string $description): void
            {
                register_nav_menu($location, $description);
            }

            public function getPostType(?int $postId = null): ?string
            {
                return get_post_type($postId) ?: null;
            }

            public function homeUrl(string $path = '', string $scheme = null): string
            {
                return home_url($path, $scheme);
            }

            public function isArchive(): bool
            {
                return is_archive();
            }

            public function isSingle(): bool
            {
                return is_single();
            }

            public function registerRestRoute(string $namespace, string $route, array $args): bool
            {
                return register_rest_route($namespace, $route, $args);
            }

            public function wpEnqueueStyle(
                string $handle,
                ?string $src = null,
                ?array $deps = null,
                ?string $ver = null,
                ?string $media = null
            ): void {
                wp_enqueue_style($handle, $src ?? '', $deps ?? [], $ver ?? false, $media ?? 'all');
            }

            public function wpEnqueueScript(
                string $handle,
                ?string $src = null,
                ?array $deps = null,
                ?string $ver = null,
                ?bool $inFooter = null
            ): void {
                wp_enqueue_script(
                    $handle,
                    $src ?? '',
                    $deps ?? [],
                    $ver ?? false,
                    $inFooter ?? false
                );
            }

            public function getPostTypeObject(string $postType): ?WP_Post_Type
            {
                return get_post_type_object($postType);
            }

            public function getPostTypeArchiveLink(string $postType)
            {
                return get_post_type_archive_link($postType);
            }

            public function addAction(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void
            {
                add_action($tag, $callback, $priority, $accepted_args);
            }

            public function addFilter(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void
            {
                add_filter($tag, $callback, $priority, $accepted_args);
            }
        };
    }
}
