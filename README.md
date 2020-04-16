# Photo Organization

Organize photos and videos date by date.

The process will create directory for each date and copy each file into corresponding directory.

## Prerequisite

1. [PHP][] 7.2.5 and later
2. [Composer][]

[Composer]: https://getcomposer.org/download
[PHP]: https://www.php.net/downloads

## Get Started

1. Build the project.

    ```
    make build
    ```

2. Set the config file `config/photo_organization`.

    + device: The device/app used to take photos. See [Supported Devices](#Supported-Devices) for available values.
    + See the config file for detailed options.

3. Run the command.

    ```
    php artisan photo:organize
    ```

## Supported Devices

### Pixel3

+ General photos.
+ Mp4 videos.
+ Portrait directories will be unfolded and files in it will be renamed as general photos. The filename of portrait photo will be suffixed with `_PORTRAIT`.

### default

+ EXIF files.
+ Multimedia.
