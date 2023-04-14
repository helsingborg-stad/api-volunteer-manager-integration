<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query\Context;

interface VQContextFactory {
	function createContext(): VQContext;
}