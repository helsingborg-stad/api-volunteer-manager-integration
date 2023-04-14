<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context;

interface ServerRequestContext {
	function getPath(): string;
}