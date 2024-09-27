<?php

namespace App\Realisation\Interface;

use App\Realisation\Entities\Author;
use App\Realisation\Entities\Borrow;
use App\Realisation\Entities\Reader;
use App\Realisation\Managers\Console;
use App\Realisation\Entities\Book;
use App\Realisation\Services\BookService;
use App\Realisation\Services\AuthorService;
use App\Realisation\Services\BorrowService;
use App\Realisation\Services\ReaderService;

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

        $this->value = $this->askQuestion("Enter the letter to continue (or type 'back' to get back): ", $this->expect);
        if ($this->value === 'back') {
            return;
        }

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

        $this->value = $this->askQuestion("Enter the number to continue (or type 'back' to get back): ", $this->expect);
        if ($this->value === 'back') {
            return;
        }

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
                $firstName = $this->askQuestion("Enter the first name (or type 'back' to get back): ");
                if ($firstName === 'back') return;
                $lastName = $this->askQuestion("Enter the last name (or type 'back' to get back): ");
                if ($lastName === 'back') return;
                $nationality = $this->askQuestion("Enter the nationality (or type 'back' to get back): ");
                if ($nationality === 'back') return;

                $author = new Author($firstName, $lastName, $nationality);
                $this->authorService->addAuthor($author);

                $this->separator();
                $this->printLine("Author has been added!");
                $this->separator();
                break;

            case '3':
                removeAuthorLable:
                $author = $this->askQuestion("Enter the author id (or type 'back' to get back): ");
                if ($author === 'back') return;
                $authorInstance = $this->authorService->getAuthor($author);

                if (is_null($authorInstance)) {
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
                $author = $this->askQuestion("Enter the author id (or type 'back' to get back): ");
                if ($author === 'back') return;
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

                $this->value = $this->askQuestion("Enter the number (or type 'back' to get back): ", $this->expect);
                if ($this->value === 'back') return;

                switch ($this->value) {
                    case '1':
                        $newFirstName = $this->askQuestion("Enter the new first name (or type 'back' to get back): ");
                        if ($newFirstName === 'back') return;
                        $authorInstance->setFirstName($newFirstName);
                        break;

                    case '2':
                        $newLastName = $this->askQuestion("Enter the last name (or type 'back' to get back): ");
                        if ($newLastName === 'back') return;
                        $authorInstance->setLastName($newLastName);
                        break;

                    case '3':
                        $newNationality = $this->askQuestion("Enter the new nationality (or type 'back' to get back): ");
                        if ($newNationality === 'back') return;
                        $authorInstance->setNationality($newNationality);
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

        $this->value = $this->askQuestion("Enter the number to continue (or type 'back' to get back): ", $this->expect);
        if ($this->value === 'back') {
            return;
        }

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
                $firstName = $this->askQuestion("Enter the first name (or type 'back' to get back): ");
                if ($firstName === 'back') return;
                $lastName = $this->askQuestion("Enter the last name (or type 'back' to get back): ");
                if ($lastName === 'back') return;

                $reader = new Reader($firstName, $lastName);
                $this->readerService->addReader($reader);

                $this->separator();
                $this->printLine("Reader has been added!");
                $this->separator();
                break;

            case '3':
                removeReaderLable:
                $reader = $this->askQuestion("Enter the reader id (or type 'back' to get back): ");
                if ($reader === 'back') return;
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
                $reader = $this->askQuestion("Enter the reader id (or type 'back' to get back): ");
                if ($reader === 'back') return;
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

                $this->value = $this->askQuestion("Enter the number (or type 'back' to get back): ", $this->expect);
                if ($this->value === 'back') return;

                switch ($this->value) {
                    case '1':
                        $newFirstName = $this->askQuestion("Enter the new first name (or type 'back' to get back): ");
                        if ($newFirstName === 'back') return;
                        $readerInstance->setFirstName($newFirstName);
                        break;

                    case '2':
                        $newLastName = $this->askQuestion("Enter the last name (or type 'back' to get back): ");
                        if ($newLastName === 'back') return;
                        $readerInstance->setLastName($newLastName);
                        break;

                    case '3':
                        $newAddress = $this->askQuestion("Enter the new address (or type 'back' to get back): ");
                        if ($newAddress === 'back') return;
                        $readerInstance->setAddress($newAddress);
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

        $this->value = $this->askQuestion("Enter the number to continue (or type 'back' to get back): ", $this->expect);
        if ($this->value === 'back') {
            return;
        }

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
                $book = $this->askQuestion("Enter the book title / id or ISBN (or type 'back' to get back): ");
                if ($book === 'back') return;
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto borrowBookLable;
                } else if($this->bookService->isBookBorrowed($bookInstance)) {
                    $this->printLine("Book already borrowed, please try again.");
                    goto borrowBookLable;
                }

                borrowReaderLable:
                $reader = $this->askQuestion("Enter the reader id (or type 'back' to get back): ");
                if ($reader === 'back') return;
                $readerInstance = $this->readerService->getReader($reader);
                if (is_null($readerInstance)) {
                    $this->printLine("Reader not found, please try again.");
                    goto borrowReaderLable;
                }

                $returnDate = (int) $this->askQuestion("Enter how many days are you going to borrow it (or type 'back' to get back): ");
                if ($returnDate === 'back') return;

                $borrow = new Borrow($this->getDate(), $this->getDate($returnDate), null, $readerInstance, $bookInstance);
                $this->borrowService->addBorrowing($borrow);

                $this->separator();
                $this->printLine("Borrowing has been added !");
                $this->separator();
                break;

            case '4':
                $book = $this->askQuestion("Enter the book title / id or ISBN (or type 'back' to get back): ");
                if ($book === 'back') return;
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
                $title = $this->askQuestion("Enter the title (or type 'back' to get back): ");
                if ($title === 'back') return;
                $isbn = $this->askQuestion("Enter the ISBN (or type 'back' to get back): ");
                if ($isbn === 'back') return;
                $publishing_date = $this->askQuestion("Enter the publishing date (or type 'back' to get back): ");
                if ($publishing_date === 'back') return;
                enterAuthorId:
                $author = $this->askQuestion("Enter the author id (or type 'back' to get back): ");
                if ($author === 'back') return;

                $authorInstance = $this->authorService->getAuthor($author);
                if (is_null($authorInstance)) {
                    $this->printLine("Author not found, please try again.");
                    goto enterAuthorId;
                }

                $book = new Book($isbn, $title, $publishing_date, $authorInstance);
                $this->bookService->addBook($book);

                $this->separator();
                $this->printLine("Book has been added!");
                $this->separator();
                break;

            case '6':
                removeBookLable:
                $book = $this->askQuestion("Enter the book title / id or ISBN (or type 'back' to get back): ");
                if ($book === 'back') return;
                $bookInstance = $this->bookService->getBook($book);
                if (is_null($bookInstance)) {
                    $this->printLine("Book not found, please try again.");
                    goto removeBookLable;
                }

                if($this->bookService->isBookBorrowed($bookInstance)) {
                    $this->printLine("Book is not available in the library right now.");
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
                $book = $this->askQuestion("Enter the book title / id or ISBN (or type 'back' to get back): ");
                if ($book === 'back') return;
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

                $this->value = $this->askQuestion("Enter the number (or type 'back' to get back): ", $this->expect);
                if ($this->value === 'back') return;

                switch ($this->value) {
                    case '1':
                        $newTitle = $this->askQuestion("Enter the new title (or type 'back' to get back): ");
                        if ($newTitle === 'back') return;
                        $bookInstance->setTitle($newTitle);
                        break;

                    case '2':
                        $newISBN = $this->askQuestion("Enter the ISBN (or type 'back' to get back): ");
                        if ($newISBN === 'back') return;
                        $bookInstance->setISBN($newISBN);
                        break;

                    case '3':
                        $newPublishingDate = $this->askQuestion("Enter the publishing date (or type 'back' to get back): ");
                        if ($newPublishingDate === 'back') return;
                        $bookInstance->setPublishingDate($newPublishingDate);
                        break;

                    case '4':
                        findAuthor:
                        $author = $this->askQuestion("Enter the author id (or type 'back' to get back): ");
                        if ($author === 'back') return;
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
                    $this->printLine("Actual return date : ".($borrowing->getActualReturnDate() ?? "Not returned yet"));
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