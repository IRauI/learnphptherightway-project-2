<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\DB;

class Transaction
{
    private DB $db;
    public function __construct()
    {
        $this->db = App::DB();
    }

    public function create(string $date, string $check, string $description, float $amount)
    {
        $stmt = $this->db->prepare('INSERT INTO transactions (date, check, description, amount)
                            VALUES (?,?,?,?)');
        
        $stmt->execute([$date,$check,$description,$amount]);

        return (int) $this->db->lastInsertId();
    }
}