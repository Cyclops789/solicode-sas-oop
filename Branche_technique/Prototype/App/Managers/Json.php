<?php

namespace App\Managers;

class Json {

    protected string $dataFile = __DIR__."/../DB/Database.json";
    protected array|null $data = null;
    protected string $modelValue;

    public function setModel(string $model)
    {
        $this->modelValue = $model;
    }

    public function insertRow(array $row): bool
    {
        $newData = [...$this->getFileData(), $row];
        return $this->setFileData($newData);
    }

    public function removeRow(string|int $id, string $by = 'id'): bool
    {   
        $data = $this->getFileData();
        $index = $this->getRowIndex($id, $data, $by);

        if(is_int($index) && $index !== -1) {
            unset($data[$index]);
            return $this->setFileData($data);
        }
        return false;
    }

    public function getRow(string|int $id, string $by = 'id'): void
    {
        $data = $this->getFileData();
        $index = $this->getRowIndex($id, $data, $by);

        if(is_int($index)) {
            $this->data = $data[$index];
            return;
        }
        $this->data = null;
    }

    public function getRowIndex(string|int $needle, array $data, string $by = 'id'): int
    {
        $index = array_search($needle, array_column($data, $by));
        return $index === false ? -1 : $index;
    }

    function setFileData(array $data): bool
    {
        
        $bytes = file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
        if(!$bytes) {
            return false;
        }
        return true;
    }

    public function getFileData(): array
    {
        if(!file_exists($this->dataFile)) {
            // Touch the file
            file_put_contents($this->dataFile, "{}");
            return [];
        }
        $data = json_decode(file_get_contents($this->dataFile));
        return match ($this->modelValue) {
            "books" => $data->books,
        };
    }

    public static function getID(): int
    {
        return random_int(1000, 9999);
    }

    public static function getDate(): string
    {
        return date("F j, Y, g:i a");
    }
}