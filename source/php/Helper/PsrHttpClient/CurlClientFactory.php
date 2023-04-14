<?php

namespace APIVolunteerManagerIntegration\Helper\PsrHttpClient;

use Http\Client\Curl\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CurlClientFactory implements HttpClientFactory {
	public function createClient(): ClientInterface {
		return new class( new Client() ) implements ClientInterface {
			private ClientInterface $client;

			public function __construct( ClientInterface $client ) {
				$this->client = $client;
			}

			public function sendRequest( RequestInterface $request ): ResponseInterface {
				return $this->client->sendRequest( $request );
			}
		};
	}
}
