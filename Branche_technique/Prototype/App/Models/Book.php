<?php

namespace App\Models;

use App\Managers\Console;

class Book extends Console
{
    private $modelStructure = [
        'id',
        'title',
        'author_id',
        'isbn',
        'available',
        'published_at',
    ];
    private bool $authorMode;

    public function __construct($console = true)
    {
        $this->setModel("book_prototype");
        if($console) {
            $this->enterBooksMode();
        }
    }

    public function enterBooksMode()
    {
        $this->expect = ['a', 'b'];
        $this->printLine("[a] - Show all books");
        $this->printLine("[b] - Add a books");
        $this->printLine("Type 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $books = $this->getAllBooks();
                
                $this->separator();
                foreach ($books as $book) {
                    $this->printLine("{$book['isbn']} - {$book['title']}");
                }
                $this->separator();

                break;

            case 'b':
                $this->addBook();
                break;
        }
        $this->enterBooksMode();
    }

    public function addBook()
    {
        $title = $this->askQuestion("Enter the title: ");
        $isbn = $this->askQuestion("Enter the isbn: ");
        $pub_date = $this->askQuestion("Enter the publishing date: ");
        
        $this->insertRow([
            'id' => static::getID(),
            'title' => $title,
            'author_id' => 1,
            'isbn' => $isbn,
            'available' => true,
            'published_at' => $pub_date,
        ]);

        $this->separator();
        if ($this->data) {
            $this->printLine("Your book has been added!");
        } else {
            $this->printLine("Failed to save the book");
        }
        $this->separator();
    }

    public function getAllBooks()
    {
        return $this->getFileData();
    }
}