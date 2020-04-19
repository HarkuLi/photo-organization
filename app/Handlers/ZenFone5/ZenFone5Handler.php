<?php

namespace App\Handlers\ZenFone5;

use App\Handlers\DeviceHandler;
use App\Handlers\ExifPhotoHandler;
use App\Handlers\MultiMediaHandler;

/**
 * Handle the directory that contains photos of ZenFone5.
 */
class ZenFone5Handler extends DeviceHandler
{
    /**
     * @inheritDoc
     */
    protected $handlers = [
        ExifPhotoHandler::class,
        MultiMediaHandler::class,
    ];
}
