<?php
namespace App\Handlers\Pixel3\Portrait;

use App\Handlers\ExifPhotoHandler;

/**
 * Handle general photos in the portrait directory.
 */
class GeneralPhotoHandler extends ExifPhotoHandler
{
    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return preg_match('/^.*PORTRAIT_\d{5}_BURST\d{17}.jpg$/', basename($path)) === 1
            && parent::isType($path);
    }

    /**
     * @inheritDoc
     */
    protected function getNewFilename(string $path): string
    {
        return basename(dirname($path)).'.jpg';
    }
}
