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

    /**
     * @return Borrow[]
     */
    public function getBorrowings()
    {
        return $this->database->borrowings;
    }

    public function addBorrowing(Borrow $borrow): void
    {
        $this->database->borrowings = [...$this->database->borrowings, $borrow];
        $this->database->saveData();
    }

    /**
     * @param Borrow[] $borrow
     * @return void
     */
    public function setBorrowings($borrow): void
    {
        $this->database->borrowings = $borrow;
        $this->database->saveData();
    }

    public function getBorrowing(mixed $needle): Borrow|null
    {
        /** @var Borrow[] */
        $borrowings = $this->getBorrowings();
        $borrowingsFiltered = array_values(array_filter($borrowings, function (Borrow $borrowing) use ($needle) {
            if ($borrowing->getId() === (int) $needle) {
                return true;
            }
            return false;
        }));

        if (sizeof($borrowingsFiltered) > 0) {
            return $borrowingsFiltered[0];
        }

        return null;
    }
}