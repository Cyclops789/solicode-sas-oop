<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Reader;

class ReaderDAO
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getReaders(): array
    {
        return $this->database->readers;
    }

    public function addReader(Reader $reader): void
    {
        $this->database->readers = [...$this->database->readers, $reader];
        $this->database->saveData();
    }
}