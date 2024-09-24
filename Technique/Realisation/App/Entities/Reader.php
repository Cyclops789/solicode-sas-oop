<?php

namespace App\Entities;

class Reader
{
    private $id;
    private $card_number;
    private $first_name;
    private $last_name;
    private $address;
    private $borrowings = [];

    public function __construct($id, $card_number, $first_name, $last_name, $borrowings = [])
    {
        $this->id = $id;
        $this->card_number = $card_number;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->borrowings = $borrowings;
    }
    
    /**
     * Get the value of borrowings
     */ 
    public function getBorrowings()
    {
        return $this->borrowings;
    }

    /**
     * Set the value of borrowings
     *
     * @return  self
     */ 
    public function setBorrowings($borrowings)
    {
        $this->borrowings = $borrowings;

        return $this;
    }

    /**
     * Get the value of card_number
     */ 
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * Set the value of card_number
     *
     * @return  self
     */ 
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;

        return $this;
    }

    /**
     * Get the value of first_name
     */ 
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
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
}