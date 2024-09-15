<?php

namespace App\Models;

class Borrowing {
    private $modelStructure = [
        'id',
        'start_id',
        'expected_return_date',
        'actual_return_date',
        'borrowed_books_ids',
        'reader_id',
    ];

    public function __construct(array $book)
    {

    }
}