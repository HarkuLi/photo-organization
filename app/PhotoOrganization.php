<?php
namespace App;

use Illuminate\Support\Facades\Config;

class PhotoOrganization
{
    public function run(): void
    {
        $this->handlePhotos();
    }

    private function handlePhotos(): void
    {
        $fileList = scandir(Config::get('photo_organization.sourceDirectory'));
        array_walk($fileList, function (string $filename) {
            if (!$this->isPhotoFile($filename)) {
                return;
            }

            $file = new File(
                Config::get('photo_organization.sourceDirectory').DIRECTORY_SEPARATOR.$filename
            );
            $file->copyTo($this->getDestinationPath($filename));
        });
    }

    private function isPhotoFile(string $filename): bool
    {
        return preg_match('/^IMG_\d{8}_\d{6}.jpg$/', $filename) === 1;
    }

    private function getDestinationPath(string $filename): string
    {
        $nameTokens = explode('_', $filename);
        $date = $nameTokens[1];
        return implode(DIRECTORY_SEPARATOR, [
            Config::get('photo_organization.destinationDirectory'),
            $date,
            $filename
        ]);
    }
}
