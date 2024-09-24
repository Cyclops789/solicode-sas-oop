<?php

class Book {
    private $id;
    private $title;
    private $isbn;

    public function __construct($id, $title, $isbn)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
    }

    public function setID(int $id)
    {
        $this->id = $id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setISBN(string $isbn)
    {
        $this->isbn = $isbn;
    }
    
    public function getID()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getISBN()
    {
        return $this->isbn;
    }
}