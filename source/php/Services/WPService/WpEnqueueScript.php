<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

/**
 * Interface for the WordPress function wp_enqueue_script().
 */
interface WpEnqueueScript
{
    /**
     * Registers the script if it hasn't been registered already, and enqueues it.
     *
     * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     *
     * @param  string  $handle  Name of the script. Should be unique.
     * @param  string  $src  Full URL of the script, or path of the script relative to the WordPress root directory.
     * @param  array  $deps  Optional. An array of registered script handles this script depends on.
     * @param  string|null  $ver  Optional. String specifying script version number, if it has one, which is added to
     *     the URL as a query string for cache busting purposes. If set to null, no version is added.
     * @param  bool|null  $inFooter  Optional. Whether to enqueue the script before </head> or before </body>.
     */
    public function wpEnqueueScript(
        string $handle,
        ?string $src = null,
        ?array $deps = null,
        ?string $ver = null,
        ?bool $inFooter = null
    ): void;
}
