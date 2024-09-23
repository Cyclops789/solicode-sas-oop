<?php

namespace App\Services;

use App\DataAccess\Book as BookDataAccess;
use App\Entities\Book;
use App\DB\Json;

class BookService extends Json {

    private BookDataAccess $book;

    public function __construct()
    {
        $this->book = new BookDataAccess();
    }

    public function getBooks()
    {
        return $this->book->getBooks();
    }

    public function addBook(Book $book)
    {
        $this->book->addBook($book);
    }
}