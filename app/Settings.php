<?php
namespace App;

class Settings
{
    private const SETTING_FIlE_PATH = __DIR__.DIRECTORY_SEPARATOR.
        '..'.DIRECTORY_SEPARATOR.
        'settings.json';

    private $setting;

    public function __construct(string $filePath = null)
    {
        $this->setting = json_decode(
            file_get_contents($filePath ?? self::SETTING_FIlE_PATH)
        );

        $this->setting->sourceDirectory = rtrim(
            $this->setting->sourceDirectory,
            DIRECTORY_SEPARATOR
        );
        $this->setting->destinationDirectory = rtrim(
            $this->setting->destinationDirectory,
            DIRECTORY_SEPARATOR
        );
    }

    public function getSourceDirectory(): string
    {
        return $this->setting->sourceDirectory;
    }

    public function getDestinationDirectory(): string
    {
        return $this->setting->destinationDirectory;
    }
}
