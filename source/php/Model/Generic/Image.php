<?php

namespace APIVolunteerManagerIntegration\Model\Generic;

class Image extends Resource
{
    public string $altText;
    public int $width;
    public int $height;

    public function __construct(
        int $id,
        string $mimeType,
        string $fileName,
        string $source,
        string $altText,
        int $width,
        int $height
    ) {
        parent::__construct($id, $mimeType, $fileName, $source);
        $this->altText = $altText;
        $this->width   = $width;
        $this->height  = $height;
    }
}