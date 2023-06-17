<?php

namespace APIVolunteerManagerIntegration\Services\AssetsService;

interface AssetsService
{
    public function getAssetUrl(string $key): string;
}