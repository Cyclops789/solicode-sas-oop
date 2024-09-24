<?php

namespace App\Interface;

use App\Managers\Console;
use App\Entities\Book;
use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\BorrowService;
use App\Services\ReaderService;

class ConsoleInterface extends Console
{

    private AuthorService $authorService;
    private BookService $bookService;
    private BorrowService $borrowService;
    private ReaderService $readerService;

    public function __construct()
    {
        $this->authorService = new AuthorService();
        $this->bookService = new BookService();
        $this->borrowService = new BorrowService();
        $this->readerService = new ReaderService();

        $this->printLine("[ ----------------------------------------------------- ]");
        $this->printLine("[ ------------------- Library system ------------------ ]");
        $this->printLine("[ ----------------------------------------------------- ]");

        $this->expect = ['a', 'b', 'c'];
        $this->printLine("[a] - Manage books");
        $this->printLine("[b] - Manage authors");
        $this->printLine("[c] - Manage readers");
        $this->printLine("Type 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->enterBooksMode();
                break;

            case 'b':
                $this->enterAuthorsMode();
                break;

            case 'c':
                $this->enterReadersMode();
                break;
        }
    }

    public function enterAuthorsMode(): void
    {

    }

    public function enterReadersMode(): void
    {

    }

    public function enterBooksMode(): void
    {
        $bookService = new BookService();
        $this->expect = ['a', 'b', 'c', 'd', 'e', 'f'];
        $this->printLine("[a] - Show all books");
        $this->printLine("[b] - Show all Available books");
        $this->printLine("[c] - Borrow a book");
        $this->printLine("[d] - Search for a boook");
        $this->printLine("[e] - Add a books");
        $this->printLine("[f] - Remove a books");
        $this->printLine("Type 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->separator();
                foreach ($bookService->getBooks() as $book) {
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getISBN()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->separator();
                }
                break;

            case 'b':
                $this->separator();
                foreach ($bookService->getBooks() as $book) {
                    if(sizeof($book->getBorrowings()) == 0) {
                        $this->printLine("Title : {$book->getTitle()}");
                        $this->printLine("ISBN : {$book->getISBN()}");
                        $this->printLine("Publishing date : {$book->getPublishingDate()}");
                        $this->separator();
                    }
                }
                break;

            case 'e':
                $id = $this->getID();
                $title = $this->askQuestion("Enter the title: ");
                $isbn = $this->askQuestion("Enter the ISBN: ");
                $publishing_date = $this->askQuestion("Enter the publishing date: ");
                $author = $this->askQuestion("Enter the author: ");

                $authorInstance = $this->authorService->getAuthor($author);
                if(is_null($authorInstance)) {

                }
                $book = new Book($id, $isbn, $title, $publishing_date);
                $bookService->addBook($book);
        
                $this->separator();
                $this->printLine("Your book has been added!");
                $this->separator();
                break;
        }

        $this->enterBooksMode();
    }
}