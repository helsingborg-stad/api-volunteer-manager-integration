<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;

trait VirtualBootstrapState {
	private string $postTypeSlug;

	private VQPosts $source;

	public function bootstrap( string $postTypeSlug, VQPosts $source ): void {
		$this->postTypeSlug = $postTypeSlug;
		$this->source       = $source;
	}
}