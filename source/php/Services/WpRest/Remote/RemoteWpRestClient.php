<?php

namespace APIVolunteerManagerIntegration\Services\WpRest\Remote;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use Http\Factory\Diactoros\RequestFactory;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Util\PsrHttpClient\PsrClientFactory;

class RemoteWpRestClient implements WpRestClient {
	private string $apiUrl;
	private ClientInterface $client;

	/**
	 * @param string $apiUrl
	 */
	public function __construct( string $apiUrl, PsrClientFactory $clientFactory ) {
		$this->apiUrl = $apiUrl;
		$this->client = $clientFactory->createClient();
	}

	public function getTaxonomies(): array {
		return [];
	}

	/**
	 * @param string $postType
	 * @param array|null $args
	 *
	 * @return array
	 * @throws JsonException
	 * @throws ClientExceptionInterface
	 */
	public function getPosts( string $postType, ?array $args = null ): array {
		$queryArgs = http_build_query( $args ?? [] );
		$request   = ( new RequestFactory() )
			->createRequest( 'GET', "{$this->apiUrl}/wp/v2/{$postType}?{$queryArgs}" )
			->withHeader( 'Accept', 'application/json' )
			->withHeader( 'Content-Type', 'application/json' );

		$response = $this->client->sendRequest( $request );

		if ( $response->getStatusCode() === '200' ) {
			return json_decode(
				$response->getBody()->getContents(),
				true,
				512,
				JSON_THROW_ON_ERROR
			);
		}

		return [];
	}

	public function getTerms( string $taxonomy, ?array $args = null ): array {
		return [];
	}

	/**
	 * @return array
	 */
	public function getTypes(): array {
		return [];
	}
}