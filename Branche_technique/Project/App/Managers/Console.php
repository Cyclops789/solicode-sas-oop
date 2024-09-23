<?php

namespace App\Managers;

use App\Models\Reader;
use App\Models\Author;
use App\Managers\Json;

class Console extends Json {
    public string $value;
    public array $expect;

    public function __construct() 
    {
        $this->clear();
        $this->expect = ['a', 'b'];
        $this->separator();
        $this->printLine("[a] - Enter reader mode");
        $this->printLine("[b] - Enter author mode");
        $this->askQuestion("Enter the letter to continue: ", $this->expect);
        $this->separator();
        
        $this->clear();
        $this->startModelMode();
    }

    public function startModelMode()
    {
        match ($this->value) {
            'a' => new Reader(),
            'b' => new Author(),
        };
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