<?php
namespace App\Handlers;

use App\FileFactory;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Handle a file.
 */
abstract class FileHandler implements FileTypeHandlerInterface
{
    /**
     * @var FileFactory
     */
    private $fileFactory;

    public function __construct(FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }

    /**
     * @inheritDoc
     */
    final public function handle(string $path): bool
    {
        $date = $this->resolveCreatedDateTime($path)
            ->format(Config::get('photo_organization.dateFormat'));

        $this->fileFactory
            ->create($path)
            ->copyTo(implode(DIRECTORY_SEPARATOR, [
                Config::get('photo_organization.destinationDirectory'),
                $date,
                $this->getNewFilename($path),
            ]));

        return true;
    }

    /**
     * Generate new filename from original file path.
     *
     * @param string $path
     * @return string
     */
    protected function getNewFilename(string $path): string
    {
        return basename($path);
    }

     /**
      * Resolve created datetime for the file.
      *
      * @param string $path
      * @return DateTime
      */
    abstract protected function resolveCreatedDateTime(string $path): DateTime;
}
