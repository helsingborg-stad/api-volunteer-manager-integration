<?php

namespace APIVolunteerManagerIntegration\Helper\PluginManager;

/**
 * @psalm-type ActionHook = list{ string, string }|list{ string, string, ?int, ?int }
 */
interface ActionHookSubscriber
{
    /**
     *
     * @return list<ActionHook>
     */
    public static function addActions();
}
