<?php

namespace App\Services;

use App\DataAccess\BorrowDAO;
use App\Entities\Borrow;

class BorrowService {

    private BorrowDAO $borrow;

    public function __construct()
    {
        $this->borrow = new BorrowDAO();
    }

    public function getBorrowings()
    {
        return $this->borrow->getBorrowings();
    }

    public function addBorrowing(Borrow $borrow)
    {
        $this->borrow->addBorrowing($borrow);
    }

    public function getBorrowing(mixed $needle): Borrow|null
    {
        /** @var Borrow[] */
        $borrowings = $this->getBorrowings();

        if(is_numeric($needle)) {
            $borrowingsFiltered = array_filter($borrowings, function (Borrow $borrowing) use ($needle) {
                if($borrowing->getId() === (int) $needle) {
                    return true;
                }
                return false;
            });

            if(sizeof($borrowingsFiltered) > 0) {
                return $borrowingsFiltered[0];
            }
        }

        return null;
    }
}