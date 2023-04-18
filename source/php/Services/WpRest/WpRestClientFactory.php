<?php

namespace APIVolunteerManagerIntegration\Services\WpRest;

interface WpRestClientFactory
{
    function createClient(): WpRestClient;
}