<?php

namespace App\Interface;

use App\Services\BookService;
use App\Managers\Console;
use App\Entities\Book;

class ConsoleInterface extends Console
{
    public BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
        $this->printLine("[ ----------------------------------------------------- ]");
        $this->printLine("[ ------------------- Book Manager -------------------- ]");
        $this->printLine("[ ----------------------------------------------------- ]");
        $this->enterBooksMode();
    }

    public function enterBooksMode(): void
    {
        $this->expect = ['a', 'b'];
        $this->printLine("[a] - Show all books");
        $this->printLine("[b] - Add a books");
        $this->printLine("Type 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->showBooks();
                break;

            case 'b':
                $this->saveBook();
                break;
        }

        $this->enterBooksMode();
    }

    public function showBooks(): void
    {
        $this->separator();
        foreach ($this->bookService->getBooks() as $book) {
            $this->printLine("Title : {$book->getTitle()}");
            $this->printLine("ISBN : {$book->getISBN()}");
            $this->separator();
        }
    }

    public function saveBook(): void
    {
        $book = new Book();

        $book->setID($this->getID());
        $book->setTitle($this->askQuestion("Enter the title: "));
        $book->setISBN($this->askQuestion("Enter the ISBN: "));

        $this->bookService->addBook($book);

        $this->separator();
        $this->printLine("Your book has been added!");
        $this->separator();
    }
}