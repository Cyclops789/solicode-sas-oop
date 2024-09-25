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
        /** @var Author[] */
        $authors = $this->getAuthors();

        if(is_numeric($needle)) {
            $authorsFiltered = array_filter($authors, function (Author $author) use ($needle) {
                if($author->getId() === (int) $needle) {
                    return true;
                }
                return false;
            });

            if(sizeof($authorsFiltered) > 0) {
                return $authorsFiltered[0];
            }
        } else {
            $authorsFiltered = array_filter($authors, function (Author $author) use ($needle) {
                if(
                    str_starts_with(strtolower($author->getFirstName()." ".$author->getLastName()), strtolower($needle)) || 
                    str_ends_with(strtolower($author->getFirstName()." ".$author->getLastName()), strtolower($needle))
                ) {
                    return true;
                }
                return false;
            });

            if(sizeof($authorsFiltered) > 0) {
                return $authorsFiltered[0];
            }
        }

        return null;
    }
}