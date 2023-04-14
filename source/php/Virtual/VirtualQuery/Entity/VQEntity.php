<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity;

interface VQEntity {
	function registerEntity( VQFromSource $virtualQuery ): VQFromSource;
}