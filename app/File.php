<?php
namespace App;

use Exception;
use Illuminate\Support\Str;

class File
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Copy the file to the designated path.
     *
     * @param string $dst The destination file path.
     * @return File The copied file.
     */
    public function copyTo(string $dst): File
    {
        if (file_exists($dst)) {
            throw new Exception("The destination '$dst' is already existing.");
        }

        $dirPath = dirname($dst);
        if (!is_dir($dirPath) && !mkdir($dirPath, 0744, true)) {
            throw new Exception("Failed to create the directory '$dirPath'.");
        }

        if (!copy($this->path, $dst)) {
            throw new Exception("Failed to copy the file from '$this->path' to $dst.");
        }

        return new File($dst);
    }
}
