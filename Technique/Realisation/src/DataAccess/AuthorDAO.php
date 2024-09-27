<?php

namespace App\Realisation\DataAccess;

use App\Realisation\DB\Database;
use App\Realisation\Entities\Author;
use App\Realisation\Services\BookService;

class AuthorDAO
{
    private Database $database;
    private BookService $bookService;

    public function __construct()
    {
        $this->database = new Database();
        $this->bookService = new BookService();
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

    /**
     * @param Author[] $author
     * @return void
     */
    public function setAuthors($author): void
    {
        $this->database->authors = $author;
        $this->database->saveData();
    }

    public function getAuthor(mixed $needle): Author|null
    {
        /** @var Author[] */
        $authors = $this->getAuthors();
        $authorsFiltered = array_values(array_filter($authors, function (Author $author) use ($needle) {
            if ($author->getId() === (int) $needle) {
                return true;
            }
            return false;
        }));

        if (sizeof($authorsFiltered) > 0) {
            return $authorsFiltered[0];
        }

        return null;
    }

    /**
     * 
     * @param Author $book
     * @return bool true if the book were found and removed, false if the book wasnt found
     */
    public function removeAuthor(Author $author): bool
    {
        $authors = $this->getAuthors();
        /** @var Author[] */
        $restOfAuthors = array_values(array_filter($authors, function (Author $authorInstance) use ($author) {
            if ($authorInstance->getId() === $author->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfAuthors) !== sizeof($authors)) {
            try {
                $this->setAuthors($restOfAuthors);
            } finally {
                $this->bookService->removeAuthorBooks($author);
            }
            
            return true;
        }

        return false;
    }

    /**
     * @param Author $author the edited instance of the book
     * @return bool
     */
    public function editAuthor(Author $author): bool
    {
        $readers = $this->getAuthors();

        /** @var Author[] */
        $restOfAuthors = array_values(array_filter($readers, function (Author $authorInstance) use ($author) {
            if ($authorInstance->getId() === $author->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfAuthors) > 0) {
            $this->setAuthors([...$restOfAuthors, $author]);
            return true;
        }

        return false;
    }
}