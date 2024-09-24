<?php

require __DIR__.'/../Services/BookService.php';
require __DIR__.'/../Entities/Book.php';

class ConsolePresentation {

    public $bookService;
    public function __construct()
    {
        $this->bookService = new BookService();

        $this->printLine("[a] - Get all books");
        $this->printLine("[b] - Add a book");
        $value = $this->askQuestion("Please enter the character: ");

        switch ($value) {
            case 'a':
                $this->showBooks();
                break;

            case 'b':
                $this->addBook();
                break;
        }

        $this->__construct();
    }

    public function showBooks()
    {
        $this->printLine("-------------------------------------------------");
        foreach ($this->bookService->getBooks() as $book) {
            $this->printLine("ISBN: ".$book->getISBN().", Title: ".$book->getTitle());
            $this->printLine("-------------------------------------------------");
        }
    }

    public function addBook()
    {
        $title = $this->askQuestion("Enter the title");
        $isbn = $this->askQuestion("Enter the isbn");

        $book = new Book(time(), $title, $isbn);
        
        $this->bookService->addBook($book);
    }

    public function printLine(string $content)
    {
        echo $content."\n";
    }

    public function askQuestion(string $question)
    {
        $this->printLine($question);
        return trim(fgets(STDIN));
    }
}