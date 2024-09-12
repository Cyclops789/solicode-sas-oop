<?php

namespace App\Managers;

use App\Interfaces\JsonInterface;

class Json implements JsonInterface {

    private string $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__."../Database/data.json";
    }

    public function insertRow(array $row): bool
    {
        $newData = [$this->getFileData(), $row];
        return $this->appendFileData($newData);
    }

    public function removeRow(string|int $id): bool
    {   
        $data = $this->getFileData();
        $index = $this->getRowIndex($id, $data);
        
        if(is_int($index)) {
            unset($data[$index]);
            return $this->setFileData($data);
        }
        return false;
    }

    public function getRow(string|int $id): array|null
    {
        $data = $this->getFileData();
        $index = $this->getRowIndex($id, $data);

        if(is_int($index)) {
            return $data[$index];
        }
        return null;
    }

    public function getRowIndex(string|int $needle, array $data, string $by = 'id'): int
    {
        $index = array_search($needle, array_column($data, $by));
        return $index;
    }

    function appendFileData(array $data): bool
    {
        $bytes = file_put_contents($this->dataFile, json_encode($data), FILE_APPEND);
        if(!$bytes) {
            return false;
        }
        return true;
    }

    function setFileData(array $data): bool
    {
        $bytes = file_put_contents($this->dataFile, json_encode($data));
        if(!$bytes) {
            return false;
        }
        return true;
    }

    function getFileData(): array
    {
        return json_decode(file_get_contents($this->dataFile), true);
    }
}