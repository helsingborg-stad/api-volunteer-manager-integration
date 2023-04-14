<?php

namespace APIVolunteerManagerIntegration\Services\WpRest\Remote;

use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use Http\Factory\Diactoros\RequestFactory;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class RemoteWpRestClient implements WpRestClient {
	private string $apiUrl;
	private ClientInterface $client;

	public function __construct( string $apiUrl, HttpClientFactory $clientFactory ) {
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
	 */
	public function getPosts( string $postType, ?array $args = null ): array {
		try {
			$queryArgs = http_build_query( $args ?? [] );
			$request   = ( new RequestFactory() )
				->createRequest( 'GET', "$this->apiUrl/wp/v2/$postType?$queryArgs" )
				->withHeader( 'Accept', 'application/json' )
				->withHeader( 'Content-Type', 'application/json' );

			$response = $this->client->sendRequest( $request );

			if ( $response->getStatusCode() === 200 ) {
				return json_decode(
					$response->getBody()->getContents(),
					true,
					512,
					JSON_THROW_ON_ERROR
				);
			}
		} catch ( ClientExceptionInterface $e ) {
		} catch ( JsonException $e ) {
			return [];
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