<?php

namespace APIVolunteerManagerIntegration\Services\WpRest;

interface WpRestFactory {
	function createWpRestClient(): WpRestClient;
}