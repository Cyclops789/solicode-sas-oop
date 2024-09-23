<?php

require __DIR__.'/../Entities/Book.php';
require __DIR__.'/../DataAccess/BookDAO.php';

class BookService {

    private BookDAO $bookDataAccess;

    public function __construct()
    {
        $this->bookDataAccess = new BookDAO();
    }

    public function getBooks()
    {
        $this->bookDataAccess->getBooks();
    }

    public function addBook(Book $book) 
    {
        $this->bookDataAccess->addBook($book);
    }
}