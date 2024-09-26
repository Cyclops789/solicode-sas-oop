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

    /**
     * @param Borrow[] $borrow
     * @return void
     */
    public function setBorrowings($borrow): void
    {
        $this->database->borrowings = $borrow;
        $this->database->saveData();
    }

    /**
     * @param mixed $needle
     * @return Borrow[]|null
     */
    public function getBorrowing(mixed $needle)
    {
        /** @var Borrow[] */
        $borrowings = $this->getBorrowings();

        if(is_numeric($needle)) {
            $borrowingsFiltered = array_values(array_filter($borrowings, function (Borrow $borrowing) use ($needle) {
                if($borrowing->getId() === (int) $needle) {
                    return true;
                }
                return false;
            }));

            if(sizeof($borrowingsFiltered) > 0) {
                return $borrowingsFiltered;
            }
        }

        return null;
    }
}