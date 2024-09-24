<?php

class Database
{
    private string $dataFile = __DIR__ . "Database.db";
    public array $books = [];
    private string $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, "");
            return;
        }

        $content = file_get_contents($this->dataFile);
        $data = unserialize($content);
        $this->books = $data->books; 
    }

    public function addData($book)
    {
        switch ($this->model) {
            case 'books':
                $this->books = [...$this->books, $book];
                break;
        }
        
        file_put_contents($this->dataFile, serialize($this));
    }
}