<?php
namespace App\Handlers;

use App\FileFactory;
use App\GetID3Wrapper;
use DateTime;

/**
 * Handle multimedia files.
 */
class MultiMediaHandler extends FileHandler
{
    /**
     * @var GetID3Wrapper
     */
    private $getID3Wrapper;

    public function __construct(FileFactory $fileFactory, GetID3Wrapper $getID3Wrapper)
    {
        parent::__construct($fileFactory);
        $this->getID3Wrapper = $getID3Wrapper;
    }

    /**
     * @inheritDoc
     */
    public function isType(string $path): bool
    {
        return is_file($path)
            && $this->getID3Wrapper->getCreatedTimestamp($path) !== false;
    }

    /**
     * @inheritDoc
     */
    protected function resolveCreatedDateTime(string $path): DateTime
    {
        return new DateTime('@'.$this->getID3Wrapper->getCreatedTimestamp($path));
    }
}
