<?php

declare(strict_types=1);

namespace App;

/**
 * Contains a single db instance to be used by all other classes
 */
class App
{
    protected static DB $db;

    public function __construct(protected Router $router, protected array $request, protected Config $config)
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

    public function run() : void 
    {
        try{
            echo $this->router->resolve(
                $this->request['uri'],
                strtolower($this->request['method'])
            );
        }catch(Exceptions\RouteNotFoundException $e){
            http_response_code(404);

            echo View::make('error/404');
        }
    }

}