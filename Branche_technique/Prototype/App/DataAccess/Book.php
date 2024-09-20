<?php

namespace App\DataAccess;

use App\Managers\Console;

class Book extends Console
{
    public $title;
    public $author_id = 1;
    public $isbn;
    public $available = true;
    public $published_at;

    public function __construct()
    {
        $this->setModel("books");
    }

    public function getBooks(): array
    {
        return $this->getFileData();
    }

    public function addBook(): void
    {
        $this->insertRow([
            'id' => static::getID(),
            'title' => $this->title,
            'author_id' => 1,
            'isbn' => $this->isbn,
            'available' => $this->available,
            'published_at' => $this->published_at,
        ]);
    }
}