# Photo Organization

Organize photos and videos date by date.

The process will create directory for each date and copy each file into corresponding directory.

## Prerequisite

1. [GNU Make][]
2. [Docker][]
3. [Docker Compose][]

[GNU Make]: https://www.gnu.org/software/make/
[Docker]: https://www.docker.com/
[Docker Compose]: https://docs.docker.com/compose/install/

## Get Started

1. Create `.env` file.

    ```
    make .env
    ```

2. Set options in `.env` file.

    + DEVICE: The device/app used to take photos. See [Supported Devices](#Supported-Devices) for available values.
    + See [.env.example](./.env.example) for detailed options.

3. Run the application.

    ```
    make run
    ```

## Supported Devices

### Pixel3

+ General photos.
+ Mp4 videos.
+ Burst directories will be unfolded and files in it will be renamed as general photos. The filename of portrait photo will be suffixed with `_PORTRAIT`.

### ZenFone5

+ Jpg photos.
+ Mp4 videos.

### default

+ EXIF files.
+ Multimedia.
