<?php
namespace App\Handlers;

use App\Exif;
use App\FileFactory;
use App\Handlers\FileHandler;
use DateTime;

/**
 * Handle photos in EXIF(Exchangeable Image File Format).
 */
class ExifPhotoHandler extends FileHandler
{
    /**
     * @var Exif
     */
    private $exif;

    public function __construct(FileFactory $fileFactory, Exif $exif)
    {
        parent::__construct($fileFactory);
        $this->exif = $exif;
    }

    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return $this->exif->isExif($path);
    }

    /**
     * @inheritDoc
     */
    protected function resolveCreatedDateTime(string $path): DateTime
    {
        return $this->exif->getCreatedDateTime($path);
    }
}
