<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\AbstractPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\VQPluggable;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Integration\Pluggable\VQPluggableFilter;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContext;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context\VQContextFactory;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQComposableView;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\VQControllable;

class ViewControllers extends AbstractPluggable implements VQPluggable, VQPluggableFilter {
	/**
	 * @var array<int, VQComposableView>
	 */
	private array $controllers;
	private VQContextFactory $contextFactory;

	private ?VQContext $context;

	public function __construct( VQControllable $vq, VQContextFactory $contextFactory ) {
		$this->controllers    = $vq->toViewControllers();
		$this->contextFactory = $contextFactory;
		$this->context        = null;
	}

	static function addFilters(): array {
		return [
			[ 'Municipio/viewData', 'controller', 10, 1 ]
		];
	}

	public function controller( array $data ): array {
		foreach ( $this->controllers as $controller ) {
			if ( $controller->match( $this->getContext() ) ) {
				$data = $controller->compose( $data );
			}
		}

		return $data;
	}

	public function getContext(): VQContext {
		$this->context = $this->context ?? $this->contextFactory->createContext();

		return $this->context;
	}
}