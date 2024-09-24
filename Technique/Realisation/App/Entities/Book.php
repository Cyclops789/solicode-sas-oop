<?php

namespace App\Entities;

class Book
{
    private $id;
    private $isbn;
    private $title;
    private $publishing_date;

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

    public function setPublishedAt(string $published_at)
    {
        $this->published_at = $published_at;
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

    public function getPublishedAt()
    {
        return $this->publishing_date;
    }
}