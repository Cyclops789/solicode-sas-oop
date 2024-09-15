<?php

namespace App\Managers;


class Json {

    private string $dataFile;
    public array|null $data;

    public function setModel(string $model)
    {
        $this->dataFile = __DIR__."/../Databases/".$model.".json";
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
        
        if(is_int($index)) {
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
        }
        $this->data = null;
    }

    public function getRowIndex(string|int $needle, array $data, string $by = 'id'): int
    {
        $index = array_search($needle, array_column($data, $by));
        return $index;
    }

    function setFileData(array $data): bool
    {
        $bytes = file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
        if(!$bytes) {
            return false;
        }
        return true;
    }

    function getFileData(): array
    {
        if(!file_exists($this->dataFile)) {
            // Touch the file
            file_put_contents($this->dataFile, "");
            return [];
        }
        return json_decode(file_get_contents($this->dataFile), true);
    }
}