<?php

namespace App\Services;

use App\DataAccess\ReaderDAO;
use App\Entities\Reader;

class ReaderService {

    private ReaderDAO $readerDAO;

    public function __construct()
    {
        $this->readerDAO = new ReaderDAO();
    }

    /**
     * @return Reader[]
     */
    public function getReaders()
    {
        return $this->readerDAO->getReaders();
    }

    public function addReader(Reader $reader)
    {
        $this->readerDAO->addReader($reader);
    }

    /**
     * @param mixed $needle
     * @return Reader[]|null
     */
    public function getReader(mixed $needle)
    {
        return $this->readerDAO->getReader($needle); 
    }

    /**
     * 
     * @param Reader $reader
     * @return bool true if the reader were found and removed, false if the reader wasnt found
     */
    public function removeReader(Reader $reader): bool
    {
        return $this->readerDAO->removeReader($reader);
    }

    /**
     * @param Reader $reader the edited instance of the book
     * @return void
     */
    public function editReader(Reader $reader): bool
    {
        return $this->readerDAO->editReader($reader);
    }
}