<?php
namespace App\Handlers\Pixel3;

use App\Handlers\DeviceHandler;
use App\Handlers\ExifPhotoHandler;

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
    ];
}
