<?php
namespace HarkuLi\PhotoOrganization;

class PhotoOrganization
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function run(): void
    {
        $this->handlePhotos();
    }

    private function handlePhotos(): void
    {
        $fileList = scandir($this->settings->getSourceDirectory());
        array_walk($fileList, function (string $filename) {
            if (!$this->isPhotoFile($filename)) {
                return;
            }

            $file = new File(
                $this->settings->getSourceDirectory().DIRECTORY_SEPARATOR.$filename
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
            $this->settings->getDestinationDirectory(),
            $date,
            $filename
        ]);
    }
}
