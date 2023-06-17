<?php

namespace APIVolunteerManagerIntegration\Services\AssetsService;

use Error;

class Assets implements AssetsService
{
    private array $manifestJson;
    private string $distUrl;
    private string $distPath;

    public function __construct(
        ?string $distPath = null,
        ?string $distUrl = null
    ) {
        $this->distPath     = $distPath ?? API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'/dist/';
        $this->distUrl      = $distUrl ?? API_VOLUNTEER_MANAGER_INTEGRATION_URL.'/dist/';
        $this->manifestJson = $this->manifest($this->distPath.'manifest.json');
    }

    private function manifest($jsonPath): array
    {
        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        }

        return [];
    }

    public function getAssetUrl(string $key): string
    {
        $this->getAssetPath($key);

        return $this->distUrl.(! empty($this->manifestJson) && ! empty($this->manifestJson[$key]) ? $this->manifestJson[$key] : $key);
    }

    public function getAssetPath(string $key): string
    {
        $assetPath = $this->distPath.(! empty($this->manifestJson) && ! empty($this->manifestJson[$key]) ? $this->manifestJson[$key] : $key);
        if ( ! file_exists($assetPath)) {
            throw new Error('Asset does not exists: '.$assetPath);
        }

        return $assetPath;
    }
}