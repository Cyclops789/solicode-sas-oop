<?php

namespace App\Interface;

use App\Entities\Borrow;
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

        $this->printLine("[ ----------------------------------------------------- ]", "green");
        $this->printLine("[ ------------------- Library system ------------------ ]", "green");
        $this->printLine("[ ----------------------------------------------------- ]", "green");

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

        new self();
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
        $this->printLine("Type 'back' to get back or 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->separator();
                foreach ($bookService->getBooks() as $book) {
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getIsbn()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : ".($this->bookService->isBookBorrowed($book) ? "Not available" : "Available"));
                    $this->separator();
                }
                break;

            case 'b':
                $this->separator();
                foreach ($bookService->getAvailableBooks() as $book) {
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getISBN()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : Available");
                    $this->separator();
                }
                break;

            case 'c':
                borrowBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN");
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto borrowBookLable;
                }

                borrowReaderLable:
                $reader = $this->askQuestion("Enter the reader id or name (First name and Last name): ");
                $readerInstance = $this->readerService->getReader($reader);
                if (is_null($readerInstance)) {
                    $this->printLine("Reader not found, please try again.");
                    goto borrowReaderLable;
                }

                $returnDate = (int) $this->askQuestion("Enter how many days are you going to borrow it");

                $borrow = new Borrow($this->getDate(), $this->getDate($returnDate), null, $readerInstance, $bookInstance);
                $this->borrowService->addBorrowing($borrow);

                $this->separator();
                $this->printLine("Borrowing has been added!");
                $this->separator();
                break;

            case 'd':
                searchBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN");
                $booksInstances = $this->bookService->getBook($book);
                if (is_null($booksInstances)) {
                    $this->printLine("Book not found, please try again.");
                    goto searchBookLable;
                }

                if(sizeof($booksInstances) > 1) {
                    $this->separator();
                    $this->printLine("Found two books");
                }

                $this->separator();
                foreach ($booksInstances as $bookInstance) {
                    $this->printLine("Title : {$bookInstance->getTitle()}");
                    $this->printLine("ISBN : {$bookInstance->getISBN()}");
                    $this->printLine("Publishing date : {$bookInstance->getPublishingDate()}");
                    $this->printLine("Availability : ".($this->bookService->isBookBorrowed($bookInstance) ? "Not available" : "Available"));
                    $this->separator();
                }
                break;

            case 'e':
                newBook:
                $title = $this->askQuestion("Enter the title: ");
                $isbn = $this->askQuestion("Enter the ISBN: ");
                $publishing_date = $this->askQuestion("Enter the publishing date: ");
                $author = $this->askQuestion("Enter the author id or name (First name and Last name): ");

                $authorInstance = $this->authorService->getAuthor($author);
                if (is_null($authorInstance)) {
                    $this->printLine("Author not found, please try again.");
                    goto newBook;
                }

                $book = new Book($isbn, $title, $publishing_date, $authorInstance);
                $bookService->addBook($book);

                $this->separator();
                $this->printLine("Book has been added!");
                $this->separator();
                break;
            
            case 'f':
                removeBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN");
                $booksInstances = $this->bookService->getBook($book);
                if (is_null($booksInstances)) {
                    $this->printLine("Book not found, please try again.");
                    goto removeBookLable;
                }

                if(sizeof($booksInstances) > 1) {
                    $this->separator();
                    $this->printLine("We found ".sizeof($booksInstances)." results for your search");
                }

                $this->separator();
                foreach ($booksInstances as $bookInstance) {
                    $this->printLine("ID : {$bookInstance->getID()}");
                    $this->printLine("Title : {$bookInstance->getTitle()}");
                    $this->printLine("ISBN : {$bookInstance->getISBN()}");
                    $this->printLine("Publishing date : {$bookInstance->getPublishingDate()}");
                    $this->printLine("Availability : ".($this->bookService->isBookBorrowed($bookInstance) ? "Not available" : "Available"));
                    $this->separator();
                }

                askIDOfBook:
                $id = $this->askQuestion("Enter the id of the book");
                if(!is_numeric($id)) {
                    $this->printLine("Invalid id please try again.");
                    goto askIDOfBook;
                }

                $bookInstance = $this->bookService->getBook($id);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto askIDOfBook;
                }

                $bookRemoved = $this->bookService->removeBook($bookInstance[0]);

                if($bookRemoved) {
                    $this->separator();
                    $this->printLine("Book has been removed!");
                    $this->separator();
                } else {
                    $this->separator();
                    $this->printLine("Sorry the book wasnt found, please try again!");
                    $this->separator();
                    goto removeBookLable;
                }
                break;

            default:
                return;
        }
        
        $this->askQuestion("");

        $this->enterBooksMode();
    }
}