<?php

namespace App\Services;

use App\Managers\Console;
use App\DataAccess\Book;

class BookService extends Console {
    public Book $model;
    
    public function __construct($console = true)
    {
        $this->model = new Book();
        if($console) {
            $this->enterBooksMode();
        }
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
        foreach ($this->model->getBooks() as $book) {
            $this->printLine("Title : {$book['title']}");
            $this->printLine("ISBN : {$book['isbn']}");
            $this->separator();
        }
    }

    public function saveConsoleBook(): void
    {
        $this->model->title = $this->askQuestion("Enter the title: ");
        $this->model->isbn = $this->askQuestion("Enter the ISBN: ");
        $this->model->addBook();

        $this->separator();
        $this->printLine("Your book has been added!");
        $this->separator();
    }
}