<?php

namespace App\Entities;

use App\Entities\Book;

class Borrow
{
    private $id;
    private $borrowed_date;
    private $expected_return_date;
    private $actual_return_date;
    private Book $book;

    public function __construct($borrowed_date, $expected_return_date, $actual_return_date, $book)
    {
        $this->id = time();
        $this->borrowed_date = $borrowed_date;
        $this->expected_return_date = $expected_return_date;
        $this->actual_return_date = $actual_return_date;
        $this->book = $book;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of borrowed_date
     */ 
    public function getBorrowedDate()
    {
        return $this->borrowed_date;
    }

    /**
     * Set the value of borrowed_date
     *
     * @return  self
     */ 
    public function setBorrowedDate($borrowed_date)
    {
        $this->borrowed_date = $borrowed_date;

        return $this;
    }

    /**
     * Get the value of expected_return_date
     */ 
    public function getExpectedReturnDate()
    {
        return $this->expected_return_date;
    }

    /**
     * Set the value of expected_return_date
     *
     * @return  self
     */ 
    public function setExpectedReturnDate($expected_return_date)
    {
        $this->expected_return_date = $expected_return_date;

        return $this;
    }

    /**
     * Get the value of actual_return_date
     */ 
    public function getActualReturnDate()
    {
        return $this->actual_return_date;
    }

    /**
     * Set the value of actual_return_date
     *
     * @return  self
     */ 
    public function setActualReturnDate($actual_return_date)
    {
        $this->actual_return_date = $actual_return_date;

        return $this;
    }

    /**
     * Get the value of book
     */ 
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set the value of book
     *
     * @return  self
     */ 
    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }
}