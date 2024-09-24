<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Borrow;

class BorrowDAO
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getBorrowings(): array
    {
        return $this->database->borrowings;
    }

    public function addBorrowing(Borrow $borrow): void
    {
        $this->database->borrowings = [...$this->database->borrowings, $borrow];
        $this->database->saveData();
    }
}