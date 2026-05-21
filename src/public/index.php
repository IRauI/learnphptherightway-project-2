<?php

declare(strict_types=1);

//include the autoloader
require_once __DIR__ . '/../vendor/autoload.php';

//load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();