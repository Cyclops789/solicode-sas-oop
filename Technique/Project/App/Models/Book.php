<?php

namespace App\Models;

use App\Managers\Console;
use App\Models\Borrowing;
use App\Models\Author;

class Book extends Console
{
    private $modelStructure = [
        'id',
        'title',
        'author_id',
        'isbn',
        'available',
        'created_at',
    ];
    private bool $authorMode;

    public function __construct()
    {
        $this->setModel("book");
    }

    public function enterBooksMode(bool $authorMode = false)
    {
        $this->expect = ['a', 'b', 'c'];
        $this->authorMode = $authorMode;
        $this->printLine("[a] - Show all books");
        $this->printLine("[b] - Search a books");
        $this->printLine("[c] - Borrow a book");
        if ($authorMode) {
            $this->expect = [...$this->expect, 'd'];
            $this->printLine("[d] - Create a new book");
        }
        $this->printLine("Type 'back' to return to the model or 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->getAllBooks();
                break;

            case 'b':
                $this->searchForBook();
                break;

            case 'c':
                $this->borrowBook();
                break;
            
            case 'd':
                $this->borrowBook();
                break;

            case 'back':
                if($authorMode) {
                    return new Author();
                }
                return new Reader();
        }
        $this->enterBooksMode();
    }

    public function searchForBook()
    {
        $this->expect = ['a', 'b', 'c'];
        $this->printLine("[a] - Search using title");
        $this->printLine("[b] - Search using id");
        $this->printLine("[c] - Search using ISBN");
        $this->printLine("Type 'back' to return to the model or 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->askQuestion("Enter the title: ");
                $this->getRow($this->value, 'title');
                break;

            case 'b':
                $this->askQuestion("Enter the id: ");
                $this->getRow($this->value, 'id');
                break;

            case 'c':
                $this->askQuestion("Enter the isbn: ");
                $this->getRow($this->value, 'isbn');
                break;

            case 'back':
                return;
        }

        if ($this->data) {
            $this->printLine("Your book has been found!");
            if($this->data['availability'] !== 'borrowed') {
                $this->askQuestion("[Y/n] Do you want to borrow '{$this->data['title']}' ?");
                switch (strtolower($this->value)) {
                    case 'y':
                        $this->askQuestion("How much days are you going to borrow it.");
                        new Borrowing([...$this->data, 'expect_return' => $this->value], $this->authorMode ? 'author' : 'reader');
                        break;
                    
                    default:
                        $this->enterBooksMode();
                        break;
                }
            } else {
                $this->printLine("This book is already borrowed!");
            }

        } else {
            $this->printLine("Book not found, please try again");
            $this->searchForBook();
        }
    }

    public function borrowBook()
    {

    }

    public function getAllBooks()
    {
        foreach ($this->getFileData() as $book) {
            $this->printLine("{$book['isbn']} - {$book['title']}");
        }
    }
}