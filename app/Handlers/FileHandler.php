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

    /**
     * The function that should be called before handle.
     *
     * @var callable
     */
    private $beforeHandle;

    /**
     * The function that should be called after handle.
     *
     * @var callable
     */
    private $afterHandle;

    public function __construct(FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }

    /**
     * @inheritDoc
     */
    final public function handle(string $path): bool
    {
        if ($this->beforeHandle) {
            call_user_func($this->beforeHandle, $path);
        }

        $date = $this->resolveCreatedDateTime($path)
            ->format(Config::get('photo_organization.dateFormat'));

        $this->fileFactory
            ->create($path)
            ->copyTo(implode(DIRECTORY_SEPARATOR, [
                Config::get('photo_organization.destinationDirectory'),
                $date,
                $this->getNewFilename($path),
            ]));

        if ($this->afterHandle) {
            call_user_func($this->afterHandle, $path);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    final public function setBeforeHandle(callable $callable): self
    {
        $this->beforeHandle = $callable;
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function setAfterHandle(callable $callable): self
    {
        $this->afterHandle = $callable;
        return $this;
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
