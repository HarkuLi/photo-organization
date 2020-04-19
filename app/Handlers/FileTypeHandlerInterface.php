<?php

namespace App\Handlers;

/**
 * Handle a file that match specific type.
 */
interface FileTypeHandlerInterface
{
    /**
     * Handle the file.
     *
     * @param string $path The path of the file.
     * @return bool True if the file is handled successfully.
     */
    public function handle(string $path): bool;

    /**
     * Check whether the file matches the type.
     *
     * @param string $path The path of the file.
     * @return bool
     */
    public function isType(string $path): bool;

    /**
     * Set a function that will be called before the handle.
     *
     * Example for $callable:
     * function (string $path) {
     *      // do something...
     * }
     *
     * @param callable $callable
     * @return self
     */
    public function setBeforeHandle(callable $callable): self;

    /**
     * Set a function that will be called after the handle.
     *
     * Example for $callable:
     * function (string $path) {
     *      // do something...
     * }
     *
     * @param callable $callable
     * @return self
     */
    public function setAfterHandle(callable $callable): self;
}
