<?php

namespace App\Database;

class Database {

    private string $databaseFile = __DIR__."/Database.db";
    public array $books = [];

    private function getData()
    {
        if(!file_exists($this->databaseFile)) {
            file_put_contents($this->databaseFile, "");
        }

        $content = file_get_contents($this->databaseFile);
        $data = unserialize($content);
        $this->books = $data->books;
    }

    private function setData()
    {
        file_put_contents($this->databaseFile, serialize($this));
    }

    public function saveData()
    {
        $this->setData();
    }
}