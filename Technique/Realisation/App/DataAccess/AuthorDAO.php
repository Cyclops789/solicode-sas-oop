<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Author;

class AuthorDAO
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getAuthors(): array
    {
        return $this->database->authors;
    }

    public function addAuthor(Author $author): void
    {
        $this->database->authors = [...$this->database->authors, $author];
        $this->database->saveData();
    }
}