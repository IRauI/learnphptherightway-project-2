<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\DB;
use App\Exceptions\FileNotFoundException;
use App\Models\Transaction;
use App\View;

class TransactionController
{
    private DB $database;

    public function __construct()
    {
    }

    public function transactions() : View {
        return View::make('transactions', ['transactions' => $this->getAllTransactions(), 
                                            'income' => $this->totalIncome(),
                                            'expense' => $this->totalExpense(),
                                            'total' => $this->total()
                                            ]);
    }

    public function index() : View {
        return View::make('index');
    }
    
    public function storeCSV(string $filename) : void {
        $path = STORAGE_PATH . '/' . $filename;
        if(! file_exists($path))
        {
            throw new FileNotFoundException();
        }

        $file = fopen($path, 'r');
        while(!feof($file)){
            $line = fgets($file);
            if(is_string($line)){
                $data = explode(',', $line);
                $nrElements = count($data);
                $amount = '';
                for($i = 3; $i < $nrElements; $i++ ){
                    $amount .= trim($data[$i]);
                }
                new Transaction()->create(trim($data[0]), trim($data[1]), trim($data[2]), trim($amount));
            }
        }
        fclose($file);
    }

    public function getAllTransactions() : array 
    {
        $database = App::DB();
        $query = 'SELECT * FROM transactions';

        $stmt =  $database->prepare($query);
        $stmt->execute();

        return $stmt->fetchall();
    }

    public function totalIncome() : float {
        $transactions = $this->getAllTransactions();

        $sum = 0;

        foreach($transactions as $transaction){
            if($transaction['amount'][1] != '-'){
                $amount = trim($transaction['amount'], ' "$-');
                $sum += (float) $amount;
            }
        }
        return $sum;
    }

    public function totalExpense() : float {
        $transactions = $this->getAllTransactions();

        $expense = 0;

        foreach($transactions as $transaction){
            if($transaction['amount'][1] == '-'){
                $amount = trim($transaction['amount'], ' "$-');
                $expense += (float) $amount;
            }
        }
        return $expense * -1;
    }

    public function total() : float {
        return $this->totalIncome() + $this->totalExpense();
    }
}