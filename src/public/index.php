<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controllers\TransactionController;
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

//route the application


$router = new Router();

$router
    ->get('/', [new TransactionController(), 'index'])
    ->get('/transactions', [new TransactionController(), 'transactions']);

$app = new App($router, 
    ['uri' => $_SERVER['REQUEST_URI'],'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
);


$app->run();