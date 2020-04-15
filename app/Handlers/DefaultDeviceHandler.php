<?php
namespace App\Handlers;

use App\Handlers\DeviceHandler;
use App\Handlers\ExifPhotoHandler;
use App\Handlers\MultiMediaHandler;

/**
 * Default handler for unknown devices.
 */
class DefaultDeviceHandler extends DeviceHandler
{
    /**
     * @inheritDoc
     */
    protected $handlers = [
        ExifPhotoHandler::class,
        MultiMediaHandler::class,
    ];
}
