<?php

namespace App\DB;

class Database
{
    public $books = [];
    public $authors = [];
    public $readers = [];
    public $borrowings = [];

    private string $dataFile = __DIR__ . "/../DB/Database.db";

    public function __construct()
    {
        $this->getData();
    }
    private function setData(): bool
    {
        $bytes = file_put_contents($this->dataFile, serialize($this));
        if (!$bytes) {
            return false;
        }
        return true;
    }

    private function getData(): void
    {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, "");
            return;
        }

        $contents = file_get_contents($this->dataFile);
        $data = unserialize($contents);

        $this->books = $data->books;
        $this->readers = $data->readers;
        $this->authors = $data->authors;
        $this->borrowings = $data->borrowings;
    }

    public function saveData()
    {
        $this->setData();
    }
}