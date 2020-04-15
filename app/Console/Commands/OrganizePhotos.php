<?php

namespace App\Console\Commands;

use App\Handlers\DefaultDeviceHandler;
use App\Handlers\DeviceHandler;
use App\Handlers\DeviceHandlerFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Helper\ProgressBar;

class OrganizePhotos extends Command
{
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
    public function handle(DeviceHandlerFactory $deviceHandlerFactory)
    {
        $this->printTitle();
        $this->printParameterInfo();

        $handler = $deviceHandlerFactory->getHandler();
        if ($handler instanceof DefaultDeviceHandler) {
            $this->printUnsupportedDeviceWarning();
        }

        $bar = $this->initProgressBar();

        $isSuccess = $this->runHandler(
            $handler,
            $bar,
            $handledDirectoryNum,
            $handledFileNum
        );

        $this->finishProgressBar($bar);

        $this->printProcessedNum($handledDirectoryNum, $handledFileNum);

        if ($isSuccess) {
            $this->printAllSuccess();
            return;
        }

        $this->printUnprocessedList($handler->getUnhandledFiles());
    }

    private function printTitle(): void
    {
        $this->info('Begin to organize photos.');
    }

    private function printParameterInfo(): void
    {
        $this->line('');
        $this->info('Device: '.Config::get('photo_organization.device'));
        $this->info('Source directory: '.Config::get('photo_organization.sourceDirectory'));
        $this->info('Destination directory: '.Config::get('photo_organization.destinationDirectory'));
    }

    private function printUnsupportedDeviceWarning(): void
    {
        $this->line('');
        $this->line('***** Warning: Your device might be not fully supported. *****');
        $this->line(' - The process will be continued, but there might be some photos unprocessed.');
    }

    private function initProgressBar(): ProgressBar
    {
        $this->line('');

        // Initial max steps of progress bar is 1 that represents the device directory.
        $bar = $this->output->createProgressBar(1);
        $bar->setFormat(
            ' %current%/%max% [%bar%] %percent:3s%%'
            .PHP_EOL.' %message%'
        );
        $bar->start();

        return $bar;
    }

    private function runHandler(
        DeviceHandler $handler,
        ProgressBar $bar,
        &$handledDirectoryNum,
        &$handledFileNum
    ): bool {
        $handledTotal = [
            'directory' => 0,
            'file' => 0,
        ];

        $isSuccess = $handler->setBeforeHandle(function (string $path) use ($bar) {
                $bar->setMessage("Processing $path ...");
                $bar->display();

                if (is_dir($path)) {
                    // Subtract 2 because of '.' and '..' in the result of scandir().
                    $bar->setMaxSteps($bar->getMaxSteps() + count(scandir($path)) - 2);
                }
            })
            ->setAfterHandle(function (string $path) use ($bar, &$handledTotal) {
                $bar->advance();

                if (is_dir($path)) {
                    $handledTotal['directory'] += 1;
                } else {
                    $handledTotal['file'] += 1;
                }
            })
            ->handle(Config::get('photo_organization.sourceDirectory'));

        $handledDirectoryNum = $handledTotal['directory'];
        $handledFileNum = $handledTotal['file'];

        return $isSuccess;
    }

    private function finishProgressBar(ProgressBar $bar): void
    {
        $bar->setMessage('Finish.');
        $bar->finish();
        $this->line('');
    }

    private function printProcessedNum(int $processedDirectoryNum, int $processedFileNum): void
    {
        $this->line('');
        $this->info("$processedDirectoryNum directories and $processedFileNum files were processed.");
    }

    private function printAllSuccess(): void
    {
        $this->line('');
        $this->info('All files were processed successfully.');
    }

    private function printUnprocessedList(array $unprocessedList): void
    {
        $this->line('');
        $this->error(count($unprocessedList).' files/directories can\'t be processed.');
        $this->line('');
        array_walk($unprocessedList, function (string $path) {
            $this->error($path);
        });
    }
}
