<?php

namespace App\Console\Commands;

use App\Handlers\Pixel3\Pixel3Handler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class OrganizePhotos extends Command
{
    private const HANDLER_MAP = [
        'Pixel3' => Pixel3Handler::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:organize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Organize photos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $device = Config::get('photo_organization.device');
        // @todo add default handler
        App::make(self::HANDLER_MAP[$device])
            ->handle(Config::get('photo_organization.sourceDirectory'));

        // @todo unhandled file list
        // @todo progress bar
    }
}
