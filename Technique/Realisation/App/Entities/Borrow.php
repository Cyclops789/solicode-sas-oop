<?php

namespace App\Entities;

class Borrow
{
    private $id;
    private $borrowed_date;
    private $expected_return_date;
    private $actual_return_date;

    public function setID(int $id)
    {
        $this->id = $id;
    }

    public function setBorrowedDate(string $borrowed_date)
    {
        $this->borrowed_date = $borrowed_date;
    }

    public function setExpectedReturnDate(string $expected_return_date)
    {
        $this->expected_return_date = $expected_return_date;
    }

    public function setActualReturnDate(string $actual_return_date)
    {
        $this->actual_return_date = $actual_return_date;
    }

    public function getID()
    {
        return $this->borrowed_date;
    }

    public function getBorrowedDate()
    {
        return $this->borrowed_date;
    }

    public function getExpectedReturnDate()
    {
        return $this->expected_return_date;
    }

    public function getActualReturnDate()
    {
        return $this->actual_return_date;
    }
}