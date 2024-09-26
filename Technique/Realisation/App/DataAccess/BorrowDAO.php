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

    /**
     * @param Borrow $borrowing
     * @return bool true if the borrowing were found and removed, false if the borrowing wasnt found
     */
    public function removeBorrowing(Borrow $borrowing): bool
    {
        $borrowings = $this->getBorrowings();

        /** @var Borrow[] */
        $restOfBorrowings = array_values(array_filter($borrowings, function (Borrow $borrowInstance) use ($borrowing) {
            if ($borrowInstance->getId() === $borrowing->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfBorrowings) !== sizeof($borrowings)) {
            $this->setBorrowings($restOfBorrowings);
            return true;
        }

        return false;
    }
}