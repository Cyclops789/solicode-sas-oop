<?php

namespace App\Models;

use App\Managers\Console;
use App\Models\Book;

class Reader extends Console {
    private $modelStructure = [
        'id',
        'id_card',
        'first_name',
        'last_name',
        'address',
        'borrowed_ids',
    ];

    private array $currentUser;

    public function __construct()
    {
        $this->setModel("reader");
        $this->expect = ['a', 'b', 'c'];

        $this->printLine("[a] - Create reader account");
        $this->printLine("[b] - Login to a reader account");
        $this->printLine("[c] - Delete a reader account");
        $this->printLine("Type 'back' to return or 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        match ($this->value) {
            'a' => $this->createReaderAccount(),
            'b' => $this->enterReaderAccount(),
            'c' => $this->deleteReaderAccount(),
            'back' => new Console(),
        };

        if($this->currentUser) {
            (new Book())->enterBooksMode();
        } else {
            $this->__construct();
        }
    }

    public function createReaderAccount()
    {
        $fist_name = $this->askQuestion("# Enter the first name: ", []);
        $last_name = $this->askQuestion("# Enter the last name: ", []);
        $address = $this->askQuestion("# Enter the address: ", []);
        $card_id = "CD-".random_int(1, 9999);

        $this->currentUser = $data = [
            'id' => random_int(1, 9999),
            'id_card'  => $card_id,
            'first_name' => $fist_name,
            'last_name' => $last_name,
            'address' => $address,
            'borrowed_ids' => [],
        ];

        $this->insertRow($data);
        $this->clear();
        $this->separator();
        $this->printLine("Welcome {$fist_name} {$last_name}! your card id is: {$card_id}");
        $this->separator();
    }

    public function enterReaderAccount()
    {
        $this->expect = ['a', 'b'];
        $this->printLine("[a] - Enter using id");
        $this->printLine("[b] - Enter using card id");
        $this->printLine("Type 'back' to return or 'exit' to exit the application");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);

        switch ($this->value) {
            case 'a':
                $this->askQuestion("Enter the id: ");
                $this->getRow($this->value, 'id');
                break;
            case 'b':
                $this->askQuestion("Enter the card id: ");
                $this->getRow($this->value, 'id_card');
                break;
        };

        if($this->data) {
            $this->printLine("You have been successfully logged in as \n #{$this->data['id']} - {$this->data['first_name']} {$this->data['last_name']}");
            $this->currentUser = $this->data;
        } else {
            $this->printLine("User not found, please try again");
            $this->enterReaderAccount();
        }
    }

    public function deleteReaderAccount()
    {
        $this->expect = ['a', 'b'];
        $this->printLine("[a] - Delete using id");
        $this->printLine("[b] - Delete using card id");

        $this->askQuestion("Enter the letter to continue: ", $this->expect);
        
        switch ($this->value) {
            case 'a': 
                $this->askQuestion("Enter the id: ");
                $removed = $this->removeRow($this->value, 'id');
                break;
            case 'b':
                $this->askQuestion("Enter the card id: ");
                $removed = $this->removeRow($this->value, 'id_card');
                break;
        };

        if($removed) {
            $this->printLine("Reader has been successfully deleted");
            $this->__construct();
        } else {
            $this->printLine("User not found, please try again");
            $this->deleteReaderAccount();
        }
    }
}