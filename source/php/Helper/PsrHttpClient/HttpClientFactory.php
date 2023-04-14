<?php

namespace APIVolunteerManagerIntegration\Helper\PsrHttpClient;

use Psr\Http\Client\ClientInterface;

interface HttpClientFactory {
	public function createClient(): ClientInterface;
}
