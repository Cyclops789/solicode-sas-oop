<?php

namespace App\Database;

class Database {

    private string $databaseFile = __DIR__."/Database.db";
    private string $model;
    public array $books = [];


    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        if(!file_exists($this->databaseFile)) {
            file_put_contents($this->databaseFile, "");
        }

        $content = file_get_contents($this->databaseFile);
        $data = unserialize($content);
        $data->books;
    }

    public function setData()
    {
        file_put_contents($this->databaseFile, serialize($this));
    }
}