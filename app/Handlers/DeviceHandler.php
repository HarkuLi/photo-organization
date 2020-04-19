<?php

namespace App\Handlers;

/**
 * Handle the directory that contains photos of certain device.
 */
abstract class DeviceHandler extends DirectoryHandler
{
    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return is_dir($path);
    }
}
