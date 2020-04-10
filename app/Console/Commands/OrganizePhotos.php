<?php

namespace App\Console\Commands;

use App\PhotoOrganization;
use Illuminate\Console\Command;

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
    public function handle(PhotoOrganization $photoOrganization)
    {
        $photoOrganization->run();
    }
}
