<?php

namespace App\Services;

use App\DataAccess\AuthorDAO;
use App\Entities\Author;

class AuthorService {

    private AuthorDAO $authorDAO;

    public function __construct()
    {
        $this->authorDAO = new AuthorDAO();
    }

    /**
     * @return Author[]
     */
    public function getAuthors()
    {
        return $this->authorDAO->getAuthors();
    }

    public function addAuthor(Author $author)
    {
        $this->authorDAO->addAuthor($author);
    }

    public function getAuthor(mixed $needle): Author|null
    {
        return $this->getAuthor($needle);
    }
}