<?php

require __DIR__.'/Entities/Book';

class BookDAO {
    private Database $database;

    public function __construct()
    {
        $this->database = new Database("books");
    }

    public function getBooks()
    {
        return $this->database->books;
    }

    public function addBook(Book $book) 
    {
        return $this->database->addData($book);
    }
}