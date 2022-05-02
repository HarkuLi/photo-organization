<?php

namespace App;

use getID3;

/**
 * A wrapper class for getID3.
 *
 * @see https://github.com/JamesHeinrich/getID3
 */
class GetID3Wrapper
{
    /**
     * @var getID3
     */
    private $getID3;

    public function __construct(getID3 $getID3)
    {
        $this->getID3 = $getID3;
    }

    /**
     * Get created timestamp of the file.
     *
     * This function use the code of
     * {@see https://developer.wordpress.org/reference/functions/wp_get_media_creation_timestamp}.
     * And only mp4 extension has been tested.
     *
     * @param string $path Path of the file.
     * @return int|false The created timestamp of the file, or return false if not found.
     */
    public function getCreatedTimestamp(string $path)
    {
        $metadata = $this->getID3->analyze($path);
 
        if (empty($metadata['fileformat'])) {
            return false;
        }

        switch ($metadata['fileformat']) {
            case 'asf':
                if (isset($metadata['asf']['file_properties_object']['creation_date_unix'])) {
                    return (int) $metadata['asf']['file_properties_object']['creation_date_unix'];
                }
                break;

            case 'matroska':
            case 'webm':
                if (isset($metadata['matroska']['comments']['creation_time']['0'])) {
                    return strtotime($metadata['matroska']['comments']['creation_time']['0']);
                } elseif (isset($metadata['matroska']['info']['0']['DateUTC_unix'])) {
                    return (int) $metadata['matroska']['info']['0']['DateUTC_unix'];
                }
                break;

            case 'quicktime':
            case 'mp4':
                if (isset($metadata['quicktime']['moov']['subatoms']['0']['creation_time_unix'])) {
                    return (int) $metadata['quicktime']['moov']['subatoms']['0']['creation_time_unix'];
                } elseif (isset($metadata['quicktime']['timestamps_unix']['create']['moov mvhd'])) {
                    return (int) $metadata['quicktime']['timestamps_unix']['create']['moov mvhd'];
                }
                break;
        }

        return false;
    }
}
