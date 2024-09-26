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

        if(is_numeric($needle)) {
            $authorsFiltered = array_values(array_filter($authors, function (Author $author) use ($needle) {
                if($author->getId() === (int) $needle) {
                    return true;
                }
                return false;
            }));

            if(sizeof($authorsFiltered) > 0) {
                return $authorsFiltered[0];
            }
        } else {
            $authorsFiltered = array_values(array_filter($authors, function (Author $author) use ($needle) {
                if(
                    str_starts_with(strtolower($author->getFirstName()." ".$author->getLastName()), strtolower($needle)) || 
                    str_ends_with(strtolower($author->getFirstName()." ".$author->getLastName()), strtolower($needle))
                ) {
                    return true;
                }
                return false;
            }));

            if(sizeof($authorsFiltered) > 0) {
                return $authorsFiltered[0];
            }
        }

        return null;
    }
}