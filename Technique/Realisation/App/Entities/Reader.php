<?php

namespace App\Entities;

class Reader
{
    private $id;
    private $card_number;
    private $first_name;
    private $last_name;
    private $address;

    public function setID(int $id)
    {
        $this->id = $id;
    }

    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function setCardNumber(string $card_number)
    {
        $this->card_number = $card_number;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getAddress()
    {
        return $this->address;
    }
    
    public function getCardNumber()
    {
        return $this->card_number;
    }
}