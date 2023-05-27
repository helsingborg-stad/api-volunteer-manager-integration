<?php

namespace APIVolunteerManagerIntegration\Helper\PluginManager;

class WordpressFunctions
{
    public function add_action($hook, $callback, $priority = 10, $acceptedArgs = 1)
    {
        add_action($hook, $callback, $priority, $acceptedArgs);
    }

    public function add_filter($hook, $callback, $priority = 10, $acceptedArgs = 1)
    {
        add_filter($hook, $callback, $priority, $acceptedArgs);
    }
}