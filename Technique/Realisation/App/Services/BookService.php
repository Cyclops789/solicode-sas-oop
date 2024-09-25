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

    public function getBook(mixed $needle): Book|null
    {
        /** @var Book[] */
        $books = $this->getBooks();

        if(is_numeric($needle)) {
            $bookFiltered = array_filter($books, function (Book $book) use ($needle) {
                if($book->getId() === (int) $needle) {
                    return true;
                }
                return false;
            });

            if(sizeof($bookFiltered) > 0) {
                return $bookFiltered[0];
            }
        } else {
            $bookFiltered = array_filter($books, function (Book $book) use ($needle) {
                if(
                    str_ends_with(strtolower($book->getTitle()), strtolower($needle)) || 
                    str_starts_with(strtolower($book->getTitle()), strtolower($needle))
                ) {
                    return true;
                }
                return false;
            });

            if(sizeof($bookFiltered) > 0) {
                return $bookFiltered[0];
            }
        }

        return null;
    }

}