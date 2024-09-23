<?php

namespace App\DB;

class Database
{

    protected string $dataFile;
    public array|null $data = null;

    public function __construct(string $model)
    {
        $this->dataFile = __DIR__ . "/../DB/{$model}.db";
    }

    public function storeModelData(mixed $row): bool
    {
        $data = $this->getModelData(false);
        $data[] = serialize($row);
        
        $content = "";
        foreach ($data as $d) {
            if(!empty(trim($d))) {
                $content .= $d."\n";
            }
        }

        return $this->setModelData($content);
    }

    function setModelData(string $data): bool
    {
        $bytes = file_put_contents($this->dataFile, $data);
        if (!$bytes) {
            return false;
        }
        return true;
    }

    public function getModelData($serialized = true): array
    {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, "");
            return [];
        }

        $data = file($this->dataFile);
        if (!$serialized) {
            return $data;
        }
        return array_filter(array_map(function ($class) {
            return unserialize(trim($class));
        }, $data), function ($class) {
            if(!$class) {
                return false;
            }
            return true;
        });
    }
}