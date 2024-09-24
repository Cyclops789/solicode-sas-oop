<?php

namespace App\Entities;

class Author
{
    private $id;
    private $first_name;
    private $last_name;
    private $nationality;

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

    public function setNationality(string $nationality)
    {
        $this->nationality = $nationality;
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

    public function getNationality()
    {
        return $this->nationality;
    }
}