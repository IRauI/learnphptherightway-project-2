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

    /**
     * Creates a transaction to save in the database
     */
    public function create(string $date, string $check, string $description, string $amount)
    {
        $stmt = $this->db->prepare('INSERT INTO transactions (date, check_id, description, amount)
                            VALUES (?,?,?,?)');
        
        $stmt->execute([$date,$check,$description,$amount]);

        return (int) $this->db->lastInsertId();
    }

}