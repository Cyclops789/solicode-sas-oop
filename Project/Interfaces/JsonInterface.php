<?php

namespace App\Interfaces;

interface JsonInterface {
    function getFileData(): array;
    function insertRow(array $row): bool;
    function removeRow(string|int $id): bool;
    function getRow(string|int $id): array|null;
}