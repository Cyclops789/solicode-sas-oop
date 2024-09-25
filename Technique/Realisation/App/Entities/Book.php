<?php

namespace App\Entities;

class Book
{
    private $id;
    private $isbn;
    private $title;
    private $publishing_date;
    private $author;
    private $borrowings = [];

    public function __construct($isbn, $title, $publishing_date, $author, $borrowings = [])
    {
        $this->id = time();
        $this->isbn = $isbn;
        $this->title = $title;
        $this->publishing_date = $publishing_date;
        $this->author = $author;
        $this->borrowings = $borrowings;
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
     * Get the value of borrowings
     */
    public function getBorrowings()
    {
        return $this->borrowings;
    }

    /**
     * Set the value of borrowings
     *
     * @return  self
     */
    public function setBorrowings($borrowings)
    {
        $this->borrowings = $borrowings;

        return $this;
    }
}