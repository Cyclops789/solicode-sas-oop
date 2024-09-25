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

        $this->expect = ['1', '2', '3'];
        $this->printLine("[1] - Manage books");
        $this->printLine("[2] - Manage authors");
        $this->printLine("[3] - Manage readers");
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
        $this->expect = ['1', '2', '3', '4', '5', '6', '7'];

        $this->printLine("[1] - Show all books");
        $this->printLine("[2] - Show all Available books");
        $this->printLine("[3] - Borrow a book");
        $this->printLine("[4] - Search for a boook");

        $this->printLine("[5] - Add a books");
        $this->printLine("[6] - Remove a books");
        $this->printLine("[7] - Edit a book");

        $this->printLine("Type 'back' to get back or 'exit' to exit the application");

        $this->askQuestion("Enter the number to continue: ", $this->expect);

        switch ($this->value) {
            case '1':
                $this->separator();
                foreach ($bookService->getBooks() as $book) {
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getIsbn()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : ".($this->bookService->isBookBorrowed($book) ? "Not available" : "Available"));
                    $this->separator();
                }
                break;

            case '2':
                $this->separator();
                foreach ($bookService->getAvailableBooks() as $book) {
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getISBN()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : Available");
                    $this->separator();
                }
                break;

            case '3':
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

            case '4':
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

            case '5':
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
            
            case '6':
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

            case '7':
                editBook:
                $book = $this->askQuestion("Enter the book title / id or ISBN");
                $booksInstances = $this->bookService->getBook($book);
                if (is_null($booksInstances)) {
                    $this->printLine("Book not found, please try again.");
                    goto editBook;
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

                askIDOfBookEdit:
                $id = $this->askQuestion("Enter the id of the book");
                if(!is_numeric($id)) {
                    $this->printLine("Invalid id please try again.");
                    goto askIDOfBookEdit;
                }

                $bookInstance = $this->bookService->getBook($id);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto askIDOfBookEdit;
                }
                $bookInstance = $bookInstance[0];

                editBookForm:
                $this->expect = ['1', '2', '3', '4'];

                $this->printLine("[1] - Edit the title");
                $this->printLine("[2] - Edit the ISBN");
                $this->printLine("[3] - Edit the publishing date");
                $this->printLine("[4] - Edit the author");

                $this->askQuestion("Enter the number : ", $this->expect);

                switch ($this->value) {
                    case '1':
                        $bookInstance->setTitle($this->askQuestion("Enter the new title: "));
                        break;

                    case '2':
                        $bookInstance->setISBN($this->askQuestion("Enter the ISBN: "));
                        break;

                    case '3':
                        $bookInstance->setPublishingDate($this->askQuestion("Enter the publishing date: "));
                        break;

                    case '4':
                        findAuthor:
                        $author = $this->askQuestion("Enter the author id or name (First name and Last name): ");
                        $authorsInstances = $this->authorService->getAuthor($author);
                        if (is_null($authorsInstances)) {
                            $this->printLine("Author not found, please try again.");
                            goto findAuthor;
                        }
                        $bookInstance->setAuthor($authorsInstances);
                        break;
                }
                
                $this->bookService->saveBooks();

                $this->separator();
                $this->printLine("Book has been saved!");
                $this->separator();
                break;

            default:
                return;
        }
        
        $this->askQuestion("");
        $this->enterBooksMode();
    }
}