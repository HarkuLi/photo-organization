<?php
namespace App;

use DateTime;

/**
 * Wrapper for EXIF(Exchangeable Image File Format) functions.
 */
class Exif
{
    private const KEY_FILE_DATE_TIME = 'FileDateTime';

    /**
     * Determine whether the file is EXIF.
     *
     * @param string $path
     * @return bool
     */
    public function isExif(string $path): bool
    {
        return is_file($path) && exif_imagetype($path);
    }

    /**
     * Get created datetime for the file.
     *
     * @param string $path
     * @return DateTime
     */
    public function getCreatedDateTime(string $path): DateTime
    {
        return new DateTime('@'.exif_read_data($path)[self::KEY_FILE_DATE_TIME]);
    }
}
