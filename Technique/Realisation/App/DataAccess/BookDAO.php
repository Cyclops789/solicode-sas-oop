<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Book;

class BookDAO
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getBooks(): array
    {
        return $this->database->books;
    }

    public function addBook(Book $book): void
    {
        $this->database->books = [...$this->database->books, $book];
        $this->database->saveData();
    }

    /**
     * @param Book[] $books
     * @return void
     */
    public function setBooks($books): void
    {
        $this->database->books = $books;
        $this->database->saveData();
    }
}