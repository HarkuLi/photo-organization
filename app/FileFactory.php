<?php
namespace App;

/**
 * Factory class for {@see File}.
 */
class FileFactory
{
    public function create(string $path): File
    {
        return new File($path);
    }
}
