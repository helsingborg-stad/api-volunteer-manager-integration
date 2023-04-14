<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

interface VQComposableView extends VQState {
	function compose( array $data ): array;
}