<?php

namespace App\DataAccess;

use App\Managers\Console;
use App\Entities\Book as BookModel;

class Book extends Console
{
    private string $modelName = "books";
    public function __construct()
    {
        $this->setModel($this->modelName);
    }

    public function getBooks(): array
    {
        return $this->getFileData()[$this->modelName];
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