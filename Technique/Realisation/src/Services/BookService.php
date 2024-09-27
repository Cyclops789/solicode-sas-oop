<?php

namespace App\Realisation\Services;

use App\Realisation\DataAccess\BookDAO;
use App\Realisation\DataAccess\BorrowDAO;
use App\Realisation\Entities\Borrow;
use App\Realisation\Entities\Book;

class BookService
{

    private BookDAO $bookDAO;
    private BorrowDAO $borrowDAO;

    public function __construct()
    {
        $this->bookDAO = new BookDAO();
        $this->borrowDAO = new BorrowDAO();
    }

    /**
     * @return Book[]
     */
    public function getBooks()
    {
        return $this->bookDAO->getBooks();
    }

    public function addBook(Book $book)
    {
        $this->bookDAO->addBook($book);
    }

    public function getBook(mixed $needle)
    {
        return $this->bookDAO->getBook($needle);
    }

    /**
     * @param Book $book
     * @return bool true if the book were found and removed, false if the book wasnt found
     */
    public function removeBook(Book $book): bool
    {
        return $this->bookDAO->removeBook($book);
    }

    /**
     * @param Book $book the edited instance of the book
     * @return bool
     */
    public function editBook(Book $book): bool
    {
        return $this->bookDAO->editBook($book);
    }

    /**
     * @return Book[]
     */
    public function getAvailableBooks()
    {
        return $this->bookDAO->getAvailableBooks();
    }

    public function isBookBorrowed(Book $book): bool
    {
        return $this->bookDAO->isBookBorrowed($book);
    }
}