<?php

namespace App\Entities;

class Book
{
    private $id;
    private $isbn;
    private $title;

    public function setID(int $id)
    {
        $this->id = $id;
    }

    public function setISBN(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getISBN()
    {
        return $this->isbn;
    }

    public function getTitle()
    {
        return $this->title;
    }
}