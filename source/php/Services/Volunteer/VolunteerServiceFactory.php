<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;

class VolunteerServiceFactory {
	static function createFromWpRepository( WpRestClient $repository ): VolunteerService {
		return new class( $repository ) implements VolunteerService {
			private WpRestClient $repository;

			public function __construct( WpRestClient $repository ) {
				$this->repository = $repository;
			}

			function assignments(): AssignmentService {
				return new AssignmentService( $this->repository, AssignmentService::TYPE );
			}

			function toArray(): array {
				return [
					AssignmentService::class => $this->assignments(),
				];
			}
		};
	}
}