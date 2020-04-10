<?php
require_once 'vendor/autoload.php';

use App\PhotoOrganization;
use App\Providers\AppServiceProvider;
use Illuminate\Container\Container;

$container = new Container();
(new AppServiceProvider($container))->register();
$container->make(PhotoOrganization::class)->run();
