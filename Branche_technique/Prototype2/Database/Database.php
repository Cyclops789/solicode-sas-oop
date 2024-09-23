<?php

class Database
{
    private string $dataFile;

    public function __construct(string $model)
    {
        $this->dataFile = __DIR__ . "{$model}.db";
    }

    public function getModelData()
    {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, "");
        }

        return array_filter(array_map(
            fn($class) => unserialize($class),
            file($this->dataFile)
        ), function ($class) {
            if ($class) {
                return true;
            }
            return false;
        });
    }

    public function addModelData(mixed $data)
    {
        $content = file($this->dataFile);
        $content[] = serialize($data) . "\n";

        file_put_contents($this->dataFile, $content);
    }
}