<?php
namespace App\Handlers;

use App\Handlers\Pixel3\Pixel3Handler;
use App\Handlers\ZenFone5\ZenFone5Handler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Factory class for {@see DeviceHandler}.
 */
class DeviceHandlerFactory
{
    private const HANDLER_MAP = [
        'Pixel3' => Pixel3Handler::class,
        'ZenFone5' => ZenFone5Handler::class,
    ];

    /**
     * Get {@see DeviceHandler} according to 'photo_organization.device' config.
     *
     * @return DeviceHandler If the device name is unknown,
     *  {@see DefaultDeviceHandler} will be returned.
     */
    public function getHandler(): DeviceHandler
    {
        $deviceName = Config::get('photo_organization.device');

        if (isset(self::HANDLER_MAP[$deviceName])) {
            return App::make(self::HANDLER_MAP[$deviceName]);
        }

        return App::make(DefaultDeviceHandler::class);
    }
}
