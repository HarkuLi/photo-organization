<?php

namespace App\Console\Commands;

use App\Handlers\DeviceHandler;
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
        /**
         * @var DeviceHandler
         */
        $handler = App::make(self::HANDLER_MAP[$device]);

        // Initial max steps of progress bar is 1 that represents the device directory.
        $bar = $this->output->createProgressBar(1);
        $bar->setFormat(
            ' %current%/%max% [%bar%] %percent:3s%%'
            .PHP_EOL.' %message%'
        );
        $bar->start();

        $handler->setBeforeHandle(function (string $path) use ($bar) {
                $bar->setMessage("Processing $path ...");
                $bar->display();

                if (is_dir($path)) {
                    // Subtract 2 because of '.' and '..' in the result of scandir().
                    $bar->setMaxSteps($bar->getMaxSteps() + count(scandir($path)) - 2);
                }
            })
            ->setAfterHandle(function () use ($bar) {
                $bar->advance();
            })
            ->handle(Config::get('photo_organization.sourceDirectory'));

        $bar->setMessage("Finish.");
        $bar->finish();

        // @todo unhandled file list
    }
}
