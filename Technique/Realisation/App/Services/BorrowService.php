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

    public function getBorrowing(mixed $needle)
    {
        return $this->borrowDAO->getBorrowing($needle);
    }
}