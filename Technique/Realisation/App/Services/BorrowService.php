<?php

namespace App\Services;

use App\DataAccess\BorrowDAO;
use App\Entities\Borrow;

class BorrowService {

    private BorrowDAO $borrowDAO;

    public function __construct()
    {
        $this->borrowDAO = new BorrowDAO();
    }

    public function getBorrowings()
    {
        return $this->borrowDAO->getBorrowings();
    }

    public function addBorrowing(Borrow $borrow)
    {
        $this->borrowDAO->addBorrowing($borrow);
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