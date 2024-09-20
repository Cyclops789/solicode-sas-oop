<?php

namespace App\DataAccess;

use App\Managers\Console;

class Book extends Console
{
    public $title;
    public $isbn;
    
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
            'isbn' => $this->isbn,
        ]);
    }
}