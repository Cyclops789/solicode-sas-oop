<?php

namespace App\Realisation\Entities;

use App\Realisation\Entities\Author;

class Book
{
    private $id;
    private $isbn;
    private $title;
    private $publishing_date;
    private Author $author;

    public function __construct($isbn, $title, $publishing_date, $author)
    {
        $this->id = time();
        $this->isbn = $isbn;
        $this->title = $title;
        $this->publishing_date = $publishing_date;
        $this->author = $author;
    }

    /**
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of publishing_date
     */
    public function getPublishingDate()
    {
        return $this->publishing_date;
    }

    /**
     * Set the value of publishing_date
     *
     * @return  self
     */
    public function setPublishingDate($publishing_date)
    {
        $this->publishing_date = $publishing_date;

        return $this;
    }

    /**
     * Get the value of isbn
     */ 
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */ 
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }
}