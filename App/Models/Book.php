<?php

namespace App\Models;

use App\Managers\Console;

class Book extends Console {
    private $modelStructure = [
        'id',
        'title',
        'author_id',
        'isbn',
        'availability',
        'created_at',
    ];
}