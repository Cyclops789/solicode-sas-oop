<?php

namespace App\DataAccess;

use App\Database\Database;
use App\Entities\Book;

class BookDAO {
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new Database();
    }

    public function getBooks()
    {
        return $this->dataBase->books;
    }

    public function addBook(Book $book)
    {
        $this->dataBase->books = [];
    }
}