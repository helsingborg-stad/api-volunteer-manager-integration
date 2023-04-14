<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity;

interface VQFromSource {
	public function fromSource( string $sourceId ): VQEntityFactory;
}