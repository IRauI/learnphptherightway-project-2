<?php

declare(strict_types=1);

namespace App;

class App
{
    protected static DB $db;

    public function __construct()
    {
        $env = [
            'driver'   => $_ENV['DB_DRIVER'],
            'host'     => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
        ];
        static::$db = new DB($env);
    }

    static function DB() : DB 
    {
        return static::$db;
    }

}