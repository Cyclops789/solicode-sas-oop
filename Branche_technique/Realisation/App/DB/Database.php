<?php

namespace App\DB;

class Database
{
    public $books = [];
    private string $dataFile = __DIR__ . "/../DB/data.db";
    private string $model;

    public function __construct(string $model)
    {
        $this->model = $model;
        $this->setModelData();
    }

    public function storeModelData(mixed $row): bool
    {
        switch ($this->model) {
            case 'books':
                array_push($this->books, $row);
                break;
        }
        
        return $this->saveData();
    }

    function saveData(): bool
    {
        $bytes = file_put_contents($this->dataFile, serialize($this));
        if (!$bytes) {
            return false;
        }
        return true;
    }

    public function setModelData(): void
    {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, "");
            return;
        }

        $contents = file_get_contents($this->dataFile);
        $data = unserialize($contents);

        if($data) {
            switch ($this->model) {
                case 'books':
                    $this->books = $data->books;
                    break;
            }
        }
    }
}