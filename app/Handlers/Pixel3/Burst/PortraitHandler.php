<?php

namespace App\Handlers\Pixel3\Burst;

use App\Handlers\ExifPhotoHandler;

/**
 * Handle portrait photos in the burst directory.
 */
class PortraitHandler extends ExifPhotoHandler
{
    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return preg_match('/^.*PORTRAIT_\d{5}_BURST\d{17}_COVER.jpg$/', basename($path)) === 1
            && parent::isType($path);
    }

    /**
     * @inheritDoc
     */
    protected function getNewFilename(string $path): string
    {
        return basename(dirname($path)) . '_PORTRAIT.jpg';
    }
}
