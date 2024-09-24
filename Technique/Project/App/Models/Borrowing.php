<?php

namespace App\Models;
use App\Managers\Console;

class Borrowing extends Console {
    public bool $success;
    private $modelStructure = [
        'id',
        'start_date',
        'expected_return_date',
        'actual_return_date',
        'borrowed_book_id',
        'reader_id',
    ];

    public function __construct(array $book, string $finalModel)
    {
        $this->setModel('borrowing');
        if($book['availability'] !== 'borrowed') {
            $this->insertRow([
                'id' => $this->getID(),
                'borrowed_book_id' => $book['id'],
                'start_date' => $this->getDate(),
                'expected_return_date' => $book['expect_return'],
                'actual_return_date' => null,
                'reader_id' => $book['reader_id'],
            ]);
        }

        $this->setModel($finalModel);
    }
}