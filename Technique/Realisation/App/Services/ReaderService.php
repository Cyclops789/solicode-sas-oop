<?php

namespace App\Services;

use App\DataAccess\ReaderDAO;
use App\Entities\Reader;

class ReaderService {

    private ReaderDAO $reader;

    public function __construct()
    {
        $this->reader = new ReaderDAO();
    }

    public function getReaders()
    {
        return $this->reader->getReaders();
    }

    public function addReader(Reader $reader)
    {
        $this->reader->addReader($reader);
    }
}