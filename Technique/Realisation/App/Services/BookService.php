<?php

namespace App\Services;

use App\DataAccess\BookDAO;
use App\Entities\Book;

class BookService {

    private BookDAO $book;

    public function __construct()
    {
        $this->book = new BookDAO();
    }

    public function getBooks()
    {
        return $this->book->getBooks();
    }

    public function addBook(Book $book)
    {
        $this->book->addBook($book);
    }

    public function getBook(mixed $needle): Book
    {
        $books = $this->getBooks();
        if(is_numeric($needle)) {
            
        }
    }
}