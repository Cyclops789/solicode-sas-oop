<?php

namespace App\DataAccess;

use App\Managers\Console;
use App\Entities\Book as BookModel;

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

    public function addBook(BookModel $book): void
    {
        $this->insertRow([
            'id' => $book->getID(),
            'title' => $book->getTitle(),
            'isbn' => $book->getISBN(),
        ]);
    }
}