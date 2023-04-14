<?php

namespace APIVolunteerManagerIntegration\Virtual;


use APIVolunteerManagerIntegration\Services\Volunteer\VolunteerServiceFactory;
use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use APIVolunteerManagerIntegration\Virtual\PostType\Assignment;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\VirtualQueryPlugin;

class Routes extends VirtualQueryPlugin {
	private WpRestClient $repository;

	public function __construct( WpRestClient $repository ) {
		$this->repository = $repository;
	}

	function entities(): array {
		return [
			new Assignment()
		];
	}

	function source(): array {
		return VolunteerServiceFactory
			::createFromWpRepository( $this->repository )
			->toArray();
	}
}