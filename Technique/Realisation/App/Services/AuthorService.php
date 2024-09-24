<?php

namespace App\Services;

use App\DataAccess\AuthorDAO;
use App\Entities\Author;

class AuthorService {

    private AuthorDAO $author;

    public function __construct()
    {
        $this->author = new AuthorDAO();
    }

    public function getAuthors()
    {
        return $this->author->getAuthors();
    }

    public function addAuthor(Author $author)
    {
        $this->author->addAuthor($author);
    }
}