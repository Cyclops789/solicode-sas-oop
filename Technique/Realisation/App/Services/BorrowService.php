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
}