<?php

namespace APIVolunteerManagerIntegration\Helper\PluginManager;


/**
 * The PluginManager class registers objects with WordPress Hooks API.
 */
class PluginManager
{
    /**
     * Registers an object with the WordPress Plugin Hooks API.
     *
     * @param  mixed  $object  The object to be registered.
     */
    public function register($object): PluginManager
    {
        $actions = $object instanceof ActionHookSubscriber ? $object->addActions() : [];
        $filters = $object instanceof FilterHookSubscriber ? $object->addFilters() : [];

        foreach (
            [
                'action' => [...$actions],
                'filter' => [...$filters],
            ]
            as $hook => $hooks
        ) {
            foreach ($hooks as $params) {
                [$name, $fn, $priority, $args] = [...$params + [null, null, null, null]];
                $callback = [$object, $fn];

                if ($hook === 'action') {
                    $this->registerAction($name, $callback, $priority, $args);
                }

                if ($hook === 'filter') {
                    $this->registerFilter($name, $callback, $priority, $args);
                }
            }
        }

        return $this;
    }

    /**
     * Register an object with a specific action hook.
     *
     * @param  string  $name
     * @param  callable  $callback
     * @param  integer|null  $priority
     * @param  integer  $args
     *
     * @return void
     */
    private function registerAction(string $name, callable $callback, ?int $priority, ?int $args)
    {
        add_action($name, $callback, $priority ?? 10, $args ?? 1);
    }

    /**
     * Register an object with a specific filter hook.
     *
     * @param  string  $name
     * @param  callable  $callback
     * @param  integer|null  $priority
     * @param  integer|null  $args
     *
     * @return void
     */
    private function registerFilter(string $name, callable $callback, ?int $priority, ?int $args)
    {
        add_filter($name, $callback, $priority ?? 10, $args ?? 1);
    }
}
