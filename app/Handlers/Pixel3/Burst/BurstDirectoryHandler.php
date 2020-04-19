<?php
namespace App\Handlers\Pixel3\Burst;

use App\Handlers\DirectoryHandler;

/**
 * Handle directories that contains burst photos.
 */
class BurstDirectoryHandler extends DirectoryHandler
{
    /**
     * @inheritDoc
     */
    protected $handlers = [
        GeneralPortraitHandler::class,
        PortraitHandler::class,
        BurstPhotoHandler::class,
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
