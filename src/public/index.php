<?php

declare(strict_types=1);

use App\App;
use App\Router;
use App\View;

//include the autoloader
require_once __DIR__ . '/../vendor/autoload.php';

//load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//define paths
define('VIEW_PATH', '../views');
define('STORAGE_PATH', '../storage');

echo View::make('transactions');

//route the application