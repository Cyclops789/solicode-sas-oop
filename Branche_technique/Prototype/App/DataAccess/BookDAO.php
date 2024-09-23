<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Book;

class BookDAO
{
    private Database $database;
    private string $model = "books";

    public function __construct()
    {
        $this->database = new Database($this->model);
    }

    public function getBooks(): array
    {
        return $this->database->books;
    }

    public function addBook(Book $book): void
    {
        $this->database->storeModelData($book);
    }
}