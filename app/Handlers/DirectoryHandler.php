<?php
namespace App\Handlers;

use Illuminate\Support\Facades\App;

/**
 * Handle a directory.
 */
abstract class DirectoryHandler implements FileTypeHandlerInterface
{
    /**
     * A list of {@see FileTypeHandlerInterface} to run for files in the directory.
     *
     * @var String[]
     */
    protected $handlers = [];

    /**
     * A list of unhandled file path for last handling.
     *
     * Note that to ensure all elements in the list is unique, each file path
     * is stored as a key.
     * Format: [file path => null]
     *
     * @var String[]
     */
    private $unhandledFiles = [];

    /**
     * {@inheritDoc}
     *
     * Try all handlers of {@see self::$handlers} until one is matched for
     * each file in the directory.
     * If there is any file/directory unhandled, it will return false.
     * And you can call {@see self::getUnhandledFiles()} to get the list of
     * unhandled files.
     */
    final public function handle(string $path): bool
    {
        $this->unhandledFiles = [];

        $filenames = scandir($path);
        return array_reduce($filenames, function ($result, $filename) use ($path) {
            if ($filename === '.' || $filename === '..') {
                return $result;
            }

            return $result && $this->handleFile($path.DIRECTORY_SEPARATOR.$filename);
        }, true);
    }

    /**
     * Get a list of unhandled file path for last handling.
     *
     * @return String[]
     */
    final public function getUnhandledFiles(): array
    {
        return array_keys($this->unhandledFiles);
    }

    /**
     * Handle a file/directory in the directory and record files in the
     * {@see self::$unhandledFiles} if there are files unhandled.
     *
     * @param string $path
     * @return bool True if all file are handled successfullly.
     */
    private function handleFile(string $path): bool
    {
        foreach ($this->handlers as $handlerName) {
            /**
             * @var FileTypeHandlerInterface
             */
            $handler = App::make($handlerName);
            if (!$handler->isType($path)) {
                continue;
            }

            if  ($handler->handle($path)) {
                return true;
            }

            if ($handler instanceof DirectoryHandler) {
                $this->unhandledFiles = array_merge(
                    $this->unhandledFiles,
                    $handler->getUnhandledFiles()
                );
            } else {
                $this->unhandledFiles[$path] = null;
            }

            return false;
        }

        // No handler matches.
        $this->unhandledFiles[$path] = null;
        return false;
    }
}