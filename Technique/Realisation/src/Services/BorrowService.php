<?php

namespace App\Realisation\Services;

use App\Realisation\DataAccess\BorrowDAO;
use App\Realisation\Entities\Borrow;

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

    public function removeBorrowing(Borrow $borrowing)
    {
        return $this->borrowDAO->removeBorrowing($borrowing);
    }
}