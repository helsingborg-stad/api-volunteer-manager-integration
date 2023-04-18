<?php

namespace APIVolunteerManagerIntegration\Model\Resource;

class FileResource
{
    public int $id = 0;
    public string $mimeType = '';
    public string $fileName = '';

    public string $source = '';

    public function __construct(int $id, string $mimeType, string $fileName, string $source)
    {
        $this->id       = $id;
        $this->mimeType = $mimeType;
        $this->fileName = $fileName;
        $this->source   = $source;
    }
}