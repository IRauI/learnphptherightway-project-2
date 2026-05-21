<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use Throwable;

class DB
{
    private PDO $db;

    public function __construct(array $env)
    {
        try
        {
            $defaultOptions = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            $this->db = new PDO(
                $env['driver'] . ':host=' . $env['host'] . ';dbname=' . $env['database'],
                $env['user'],
                $env['password'],
                $env['options'] ?? $defaultOptions
            );
        }catch(Throwable $e){
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments) : callable
    {
        return call_user_func_array([$this->db, $name], $arguments);
    }
}