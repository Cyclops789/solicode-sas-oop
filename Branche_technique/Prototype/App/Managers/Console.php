<?php

namespace App\Managers;

use App\Managers\Json;
use App\Models\Book;

class Console extends Json {
    public string $value;
    public array $expect;

    public function __construct()
    {
        (new Book())->enterBooksMode();
    }

    public function separator()
    {
        $this->printLine("#####################################################");
    }

    public function askQuestion(string $question, array $expect = []): string 
    {
        $this->printLine($question);
        $this->value = trim(fgets(STDIN));

        if($this->value === 'exit') {
            die(0);
        }

        // verify the inputs
        if(sizeof($expect) > 0) {
            $expect = [...$expect, 'back'];
            $found = false;
            foreach ($expect as $expected) {
                if($this->value === $expected) {
                    $found = true;
                }
            }
    
            if(!$found) {
                die("Invalid value");
            }
        }

        return $this->value;
    }

    public function clear()
    {
        echo "\033[2J\033[;H";
    }

    public function printLine(string $line) 
    {
        echo $line."\n";
    }
}