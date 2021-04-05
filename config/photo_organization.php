<?php
// config file for App\Console\Commands\OrganizePhotos

return [
    'device' => config('DEVICE', 'Pixel3'),
    'sourceDirectory' => base_path() . '/source',
    'destinationDirectory' => base_path() . '/destination',
    'dateFormat' => config('DATE_FORMAT', 'Ymd'),
];
