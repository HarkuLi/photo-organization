<?php
namespace App\Handlers\Pixel3;

use App\Handlers\DeviceHandler;
use App\Handlers\ExifPhotoHandler;
use App\Handlers\MultiMediaHandler;
use App\Handlers\Pixel3\Portrait\PortraitDirectoryHandler;

/**
 * Handle the directory that contains photos of Pixel3.
 */
class Pixel3Handler extends DeviceHandler
{
    /**
     * @inheritDoc
     */
    protected $handlers = [
        ExifPhotoHandler::class,
        MultiMediaHandler::class,
        PortraitDirectoryHandler::class,
    ];
}
