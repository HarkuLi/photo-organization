<?php
namespace App\Handlers\Pixel3\Portrait;

use App\Handlers\DirectoryHandler;

/**
 * Handle directories that contains portrait photos.
 */
class PortraitDirectoryHandler extends DirectoryHandler
{
    /**
     * @inheritDoc
     */
    protected $handlers = [
        GeneralPhotoHandler::class,
        PortraitHandler::class,
    ];

    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return is_dir($path)
            && preg_match('/^IMG_\d{8}_\d{6}$/', basename($path)) === 1;
    }
}
