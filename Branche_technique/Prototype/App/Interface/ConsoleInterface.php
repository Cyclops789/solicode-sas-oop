<?php

namespace App\Interface;

use App\Services\BookService as Book;
use App\Managers\Console;
use App\Entities\Book as BookModel;

class ConsoleInterface extends Console {
    
    public Book $dataAccess;

    public function __construct()
    {
        $this->dataAccess = new Book();
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
                $this->showConsoleBooks();
                break;

            case 'b':
                $this->saveConsoleBook();
                break;
        }

        $this->enterBooksMode();
    }

    public function showConsoleBooks(): void
    {
        $this->separator();
        foreach ($this->dataAccess->getBooks() as $book) {
            $this->printLine("Title : {$book['title']}");
            $this->printLine("ISBN : {$book['isbn']}");
            $this->separator();
        }
    }

    public function saveConsoleBook(): void
    {
        $book = new BookModel();
        
        $book->setID($this->getID());
        $book->setTitle($this->askQuestion("Enter the title: "));
        $book->setISBN($this->askQuestion("Enter the ISBN: "));

        $this->dataAccess->addBook($book);

        $this->separator();
        $this->printLine("Your book has been added!");
        $this->separator();
    }
}