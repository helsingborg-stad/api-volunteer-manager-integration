<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function wp_enqueue_style().
 */
interface WpEnqueueStyle
{
    /**
     * Registers the style if it hasn't been registered already, and enqueues it.
     *
     * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style
     *
     * @param  string  $handle  Name of the stylesheet. Should be unique.
     * @param  string|null  $src  Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root
     *     directory.
     * @param  array|null  $deps  Optional. An array of registered stylesheet handles this stylesheet depends on.
     * @param  string|null  $ver  Optional. String specifying stylesheet version number, if it has one, which is added
     *     to the URL as a query string for cache busting purposes. If set to null, no version is added.
     * @param  string|null  $media  Optional. The media for which this stylesheet has been defined.
     */
    public function wpEnqueueStyle(
        string $handle,
        ?string $src = null,
        ?array $deps = null,
        ?string $ver = null,
        ?string $media = null
    ): void;
}
