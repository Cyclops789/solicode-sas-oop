<?php

namespace App\Interface;

use App\Entities\Author;
use App\Entities\Borrow;
use App\Entities\Reader;
use App\Managers\Colors;
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
        $this->printOption("Manage books", "1");
        $this->printOption("Manage authors", "2");
        $this->printOption("Manage readers", "3");
        $this->printLine("Type 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case '1':
                $this->enterBooksMode();
                break;

            case '2':
                $this->enterAuthorsMode();
                break;

            case '3':
                $this->enterReadersMode();
                break;
        }

        new self();
    }

    public function enterAuthorsMode(): void
    {
        $this->expect = ['1', '2', '3', '4'];

        $this->printOption("Show all authors", "1");
        $this->printOption("Add a author", "2");
        $this->printOption("Remove a author", "3");
        $this->printOption("Edit a author", "4");

        $this->printLine("Type 'back' to get back or 'exit' to exit the application");

        $this->askQuestion("Enter the number to continue: ", $this->expect);

        switch ($this->value) {
            case '1':
                $allAuthors = $this->authorService->getAuthors();
                $this->separator();
                foreach ($allAuthors as $author) {
                    $this->printLine("ID : {$author->getId()}");
                    $this->printLine("First name : {$author->getFirstName()}");
                    $this->printLine("Last name : {$author->getLastName()}");
                    $this->printLine("Nationality : {$author->getNationality()}");
                    $this->separator();
                }

                if(sizeof($allAuthors) === 0) {
                    $this->printLine("There are no authors at this moment.");
                    $this->separator();
                }
                break;

            case '2':
                $firstName = $this->askQuestion("Enter the first name: ");
                $lastName = $this->askQuestion("Enter the last name: ");
                $nationality = $this->askQuestion("Enter the nationality: ");

                $author = new Author($firstName, $lastName, $nationality);
                $this->authorService->addAuthor($author);

                $this->separator();
                $this->printLine("Author has been added!");
                $this->separator();
                break;

            case '3':
                removeAuthorLable:
                $author = $this->askQuestion("Enter the author id : ");
                $authorInstance = $this->authorService->getAuthor($author);

                if (is_null($authorsInstances)) {
                    $this->printLine("Author not found, please try again.");
                    goto removeAuthorLable;
                }

                $bookRemoved = $this->authorService->removeAuthor($authorInstance);

                if ($bookRemoved) {
                    $this->separator();
                    $this->printLine("Author has been removed!");
                    $this->separator();
                } else {
                    $this->separator();
                    $this->printLine("Sorry the author wasnt found, please try again!");
                    $this->separator();
                    goto removeAuthorLable;
                }
                break;

            case '4':
                editAuthor:
                $author = $this->askQuestion("Enter the author id : ");
                $authorInstance = $this->authorService->getAuthor($author);

                if (is_null($authorInstance)) {
                    $this->printLine("Author not found, please try again.");
                    goto editAuthor;
                }
                
                editAuthorForm:
                $this->expect = ['1', '2', '3'];

                $this->printOption("Edit the first name", "1");
                $this->printOption("Edit the last name", "2");
                $this->printOption("Edit the nationality", "3");

                $this->askQuestion("Enter the number : ", $this->expect);

                switch ($this->value) {
                    case '1':
                        $authorInstance->setFirstName($this->askQuestion("Enter the new first name: "));
                        break;

                    case '2':
                        $authorInstance->setLastName($this->askQuestion("Enter the last name: "));
                        break;

                    case '3':
                        $authorInstance->setNationality($this->askQuestion("Enter the new nationality: "));
                        break;

                    default:
                        goto editAuthorForm;
                }

                $this->authorService->editAuthor($authorInstance);

                $this->separator();
                $this->printLine("Author has been saved!");
                $this->separator();
                break;

            default:
                return;
        }
        $this->enterAuthorsMode();
    }

    public function enterReadersMode(): void
    {
        $this->expect = ['1', '2', '3', '4'];

        $this->printOption("Show all readers", "1");
        $this->printOption("Add a reader", "2");
        $this->printOption("Remove a reader", "3");
        $this->printOption("Edit a reader", "4");

        $this->printLine("Type 'back' to get back or 'exit' to exit the application");

        $this->askQuestion("Enter the number to continue: ", $this->expect);

        switch ($this->value) {
            case '1':
                $allReaders = $this->readerService->getReaders();
                $this->separator();
                foreach ($allReaders as $reader) {
                    $this->printLine("ID : {$reader->getId()}");
                    $this->printLine("First name : {$reader->getFirstName()}");
                    $this->printLine("Last name : {$reader->getLastName()}");
                    $this->printLine("Card number : {$reader->getCardNumber()}");
                    $this->printLine("Address : {$reader->getAddress()}");
                    $this->separator();
                }

                if(sizeof($allReaders) === 0) {
                    $this->printLine("There are no readers at this moment.");
                    $this->separator();
                }
                break;

            case '2':
                $firstName = $this->askQuestion("Enter the first name: ");
                $lastName = $this->askQuestion("Enter the last name: ");

                $reader = new Reader($firstName, $lastName);
                $this->readerService->addReader($reader);

                $this->separator();
                $this->printLine("Reader has been added!");
                $this->separator();
                break;

            case '3':
                removeReaderLable:
                $reader = $this->askQuestion("Enter the reader id : ");
                $readerInstance = $this->readerService->getReader($reader);

                if (is_null($readerInstance)) {
                    $this->printLine("Reader not found, please try again.");
                    goto removeReaderLable;
                }

                $readerRemoved = $this->readerService->removeReader($readerInstance);
                if ($readerRemoved) {
                    $this->separator();
                    $this->printLine("Reader has been removed!");
                    $this->separator();
                } else {
                    $this->separator();
                    $this->printLine("Sorry the reader wasnt found, please try again!");
                    $this->separator();
                    goto removeReaderLable;
                }
                break;

            case '4':
                editReader:
                $reader = $this->askQuestion("Enter the reader id : ");
                $readerInstance = $this->readerService->getReader($reader);

                if (is_null($readerInstance)) {
                    $this->printLine("Reader not found, please try again.");
                    goto editReader;
                }

                editReaderForm:
                $this->expect = ['1', '2', '3'];

                $this->printOption("Edit the first name", "1");
                $this->printOption("Edit the last name", "2");
                $this->printOption("Edit the address", "3");

                $this->askQuestion("Enter the number : ", $this->expect);

                switch ($this->value) {
                    case '1':
                        $readerInstance->setFirstName($this->askQuestion("Enter the new first name: "));
                        break;

                    case '2':
                        $readerInstance->setLastName($this->askQuestion("Enter the last name: "));
                        break;

                    case '3':
                        $readerInstance->setAddress($this->askQuestion("Enter the new address: "));
                        break;

                    default:
                        goto editReaderForm;
                }

                $this->readerService->editReader($readerInstance);

                $this->separator();
                $this->printLine("Reader has been saved!");
                $this->separator();
                break;

            default:
                return;
        }
        $this->enterReadersMode();
    }

    public function enterBooksMode(): void
    {
        $this->expect = ['1', '2', '3', '4', '5', '6', '7', '8'];

        $this->printOption("Show all books", "1");
        $this->printOption("Show all Available books", "2");
        $this->printOption("Borrow a book", "3");
        $this->printOption("Search for a boook", "4");

        $this->printOption("Add a books", "5");
        $this->printOption("Remove a books", "6");
        $this->printOption("Edit a book", "7");
        $this->printOption("Show all borrowings", "8");

        $this->printLine("Type 'back' to get back or 'exit' to exit the application");

        $this->askQuestion("Enter the number to continue: ", $this->expect);

        switch ($this->value) {
            case '1':
                $allBooks = $this->bookService->getBooks();
                $this->separator();
                foreach ($allBooks as $book) {
                    $this->printLine("ID : {$book->getId()}");
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getIsbn()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : " . ($this->bookService->isBookBorrowed($book) ? "Not available" : "Available"));
                    $this->printLine("Author : ".$book->getAuthor()->getFirstName()." ".$book->getAuthor()->getLastName());
                    $this->separator();
                }

                if(sizeof($allBooks) === 0) {
                    $this->printLine("There are no books at this moment.");
                    $this->separator();
                }
                break;

            case '2':
                $availableBooks = $this->bookService->getAvailableBooks();
                $this->separator();
                foreach ($availableBooks as $book) {
                    $this->printLine("ID : {$book->getId()}");
                    $this->printLine("Title : {$book->getTitle()}");
                    $this->printLine("ISBN : {$book->getISBN()}");
                    $this->printLine("Publishing date : {$book->getPublishingDate()}");
                    $this->printLine("Availability : Available");
                    $this->printLine("Author : ".$book->getAuthor()->getFirstName()." ".$book->getAuthor()->getLastName());
                    $this->separator();
                }

                if(sizeof($availableBooks) === 0) {
                    $this->printLine("There are no available books at this moment.");
                    $this->separator();
                }
                break;

            case '3':
                borrowBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN : ");
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto borrowBookLable;
                } else if($this->bookService->isBookBorrowed($bookInstance)) {
                    $this->printLine("Book already borrowed, please try again.");
                    goto borrowBookLable;
                }

                borrowReaderLable:
                $reader = $this->askQuestion("Enter the reader id : ");
                $readerInstance = $this->readerService->getReader($reader);
                if (is_null($readerInstance)) {
                    $this->printLine("Reader not found, please try again.");
                    goto borrowReaderLable;
                }

                $returnDate = (int) $this->askQuestion("Enter how many days are you going to borrow it : ");

                $borrow = new Borrow($this->getDate(), $this->getDate($returnDate), null, $readerInstance, $bookInstance);
                $this->borrowService->addBorrowing($borrow);

                $this->separator();
                $this->printLine("Borrowing has been added !");
                $this->separator();
                break;

            case '4':
                $book = $this->askQuestion("Enter the book title / id or ISBN : ");
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found.");
                    break;
                }

                $this->separator();
                $this->printLine("ID : {$bookInstance->getId()}");
                $this->printLine("Title : {$bookInstance->getTitle()}");
                $this->printLine("ISBN : {$bookInstance->getISBN()}");
                $this->printLine("Publishing date : {$bookInstance->getPublishingDate()}");
                $this->printLine("Availability : " . ($this->bookService->isBookBorrowed($bookInstance) ? "Not available" : "Available"));
                $this->printLine("Author : ".$bookInstance->getAuthor()->getFirstName()." ".$bookInstance->getAuthor()->getLastName());
                $this->separator();
                break;

            case '5':
                newBook:
                $title = $this->askQuestion("Enter the title: ");
                $isbn = $this->askQuestion("Enter the ISBN: ");
                $publishing_date = $this->askQuestion("Enter the publishing date: ");
                $author = $this->askQuestion("Enter the author id: ");

                $authorInstance = $this->authorService->getAuthor($author);
                if (is_null($authorInstance)) {
                    $this->printLine("Author not found, please try again.");
                    goto newBook;
                }

                $book = new Book($isbn, $title, $publishing_date, $authorInstance);
                $this->bookService->addBook($book);

                $this->separator();
                $this->printLine("Book has been added!");
                $this->separator();
                break;

            case '6':
                removeBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN : ");
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto removeBookLable;
                }

                $bookRemoved = $this->bookService->removeBook($bookInstance);

                if ($bookRemoved) {
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
                $book = $this->askQuestion("Enter the book title / id or ISBN : ");
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto editBook;
                }

                editBookForm:
                $this->expect = ['1', '2', '3', '4'];

                $this->printOption("Edit the title", "1");
                $this->printOption("Edit the ISBN", "2");
                $this->printOption("Edit the publishing date", "3");
                $this->printOption("Edit the author", "4");

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
                        $author = $this->askQuestion("Enter the author id : ");
                        $authorsInstances = $this->authorService->getAuthor($author);
                        if (is_null($authorsInstances)) {
                            $this->printLine("Author not found, please try again.");
                            goto findAuthor;
                        }
                        $bookInstance->setAuthor($authorsInstances);
                        break;

                    default:
                        goto editBookForm;
                }

                $this->bookService->editBook($bookInstance);

                $this->separator();
                $this->printLine("Book has been saved!");
                $this->separator();
                break;

            case '8':
                $borrowings = $this->borrowService->getBorrowings();
                $this->separator();
                foreach ($borrowings as $borrowing) {
                    $this->printLine("ID : {$borrowing->getId()}");
                    $this->printLine("Date of borrowing : {$borrowing->getBorrowedDate()}");
                    $this->printLine("Expect return date : {$borrowing->getExpectedReturnDate()}");
                    $this->printLine("Actual return date : ".($borrowing->getActualReturnDate() ?? "Not yet"));
                    $this->printLine("Book : ".$borrowing->getBook()->getId()." - ".$borrowing->getBook()->getTitle());
                    $this->separator();
                }

                if(sizeof($borrowings) === 0) {
                    $this->printLine("There are no borrowings at this moment.");
                    $this->separator();
                }
                break;

            default:
                return;
        }

        $this->enterBooksMode();
    }
}