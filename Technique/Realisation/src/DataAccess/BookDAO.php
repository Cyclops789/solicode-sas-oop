<?php

namespace App\Realisation\DataAccess;

use App\Realisation\DB\Database;
use App\Realisation\Entities\Book;
use App\Realisation\Entities\Borrow;

class BookDAO
{
    private Database $database;
    private BorrowDAO $borrowDAO;

    public function __construct()
    {
        $this->database = new Database();
        $this->borrowDAO = new BorrowDAO();
    }

    /**
     * @return Book[]
     */
    public function getBooks()
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

    public function getBook(mixed $needle): Book|null
    {
        /** @var Book[] */
        $books = $this->getBooks();

        if (is_numeric($needle)) {
            $bookFiltered = array_values(array_filter($books, function (Book $book) use ($needle) {
                if ($book->getId() === (int) $needle) {
                    return true;
                }
                return false;
            }));

            if (sizeof($bookFiltered) > 0) {
                return $bookFiltered[0];
            }

            $bookFiltered = array_values(array_filter($books, function (Book $book) use ($needle) {
                if ($book->getIsbn() === $needle) {
                    return true;
                }
                return false;
            }));

            if (sizeof($bookFiltered) > 0) {
                return $bookFiltered[0];
            }
        } else {
            $bookFiltered = array_values(array_filter($books, function (Book $book) use ($needle) {
                if (
                    str_ends_with(strtolower($book->getTitle()), strtolower($needle)) ||
                    str_starts_with(strtolower($book->getTitle()), strtolower($needle)) ||
                    strtolower($book->getISBN()) === strtolower($needle)
                ) {
                    return true;
                }
                return false;
            }));

            if (sizeof($bookFiltered) > 0) {
                return $bookFiltered[0];
            }
        }

        return null;
    }

    /**
     * 
     * @param Book $book
     * @return bool true if the book were found and removed, false if the book wasnt found
     */
    public function removeBook(Book $book): bool
    {
        $books = $this->getBooks();

        /** @var Book[] */
        $restOfBooks = array_values(array_filter($books, function (Book $bookInstance) use ($book) {
            if ($bookInstance->getId() === $book->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfBooks) !== sizeof($books)) {
            $borrowings = $this->borrowDAO->getBorrowings();
            foreach ($borrowings as $borrowing) {
                if($book->getId() === $borrowing->getBook()->getId()) {
                    $this->borrowDAO->removeBorrowing($borrowing);
                }
            }

            $this->setBooks($restOfBooks);
            return true;
        }

        return false;
    }

    /**
     * @param Book $book the edited instance of the book
     * @return void
     */
    public function editBook(Book $book): bool
    {
        $books = $this->getBooks();

        /** @var Book[] */
        $restOfBooks = array_values(array_filter($books, function (Book $bookInstance) use ($book) {
            if ($bookInstance->getId() === $book->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfBooks) > 0) {
            $this->setBooks([...$restOfBooks, $book]);
            return true;
        }

        return false;
    }

    /**
     * @return Book[]
     */
    public function getAvailableBooks()
    {
        /** @var Borrow[] */
        $borrowings = $this->borrowDAO->getBorrowings();
        $allBorrowedBooksIDs = array_flip(array_map(fn(Borrow $borrow) => $borrow->getBook()->getId(), $borrowings));

        return array_values(array_filter($this->getBooks(), function (Book $book) use ($allBorrowedBooksIDs) {
            if (isset($allBorrowedBooksIDs[$book->getID()])) {
                return false;
            }
            return true;
        }));
    }

    public function isBookBorrowed(Book $book): bool
    {
        /** @var Borrow[] */
        $borrowings = $this->borrowDAO->getBorrowings();
        $allBorrowedBooksIDs = array_flip(array_map(fn(Borrow $borrow) => $borrow->getBook()->getId(), $borrowings));
        if (isset($allBorrowedBooksIDs[$book->getID()])) {
            return true;
        }

        return false;
    }
}