<?php

namespace APIVolunteerManagerIntegration\Helper\HttpClient;

use Psr\Http\Client\ClientInterface;

interface HttpClientFactory
{
    public function createClient(): ClientInterface;
}
