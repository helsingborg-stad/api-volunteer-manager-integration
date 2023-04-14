<?php /** @noinspection PsalmGlobal */

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\State\Traits;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;

trait VirtualBootstrapState {
	private string $postType;

	private VQPosts $source;

	public function bootstrap( VQPosts $source, string $postType ): void {
		$this->postType = $postType;
		$this->source   = $source;
	}
}