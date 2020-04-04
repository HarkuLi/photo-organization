<?php
require_once 'vendor/autoload.php';

use HarkuLi\PhotoOrganization\PhotoOrganization;
use HarkuLi\PhotoOrganization\Providers\AppServiceProvider;
use Illuminate\Container\Container;

$container = new Container();
(new AppServiceProvider($container))->register();
$container->make(PhotoOrganization::class)->run();
