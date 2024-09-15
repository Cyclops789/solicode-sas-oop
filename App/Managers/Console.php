<?php

namespace App\Managers;

use App\Models\Reader;
use App\Models\Authors;
use App\Managers\Json;

class Console extends Json {
    public string $value;
    public array $expect;

    public function __construct() 
    {
        $this->expect = ['a', 'b'];
        $this->printLine("#####################################################");
        $this->printLine("[a] - Enter reader mode");
        $this->printLine("[b] - Enter author mode");
        $this->askQuestion("Enter the letter to continue: ", $this->expect);
        $this->printLine("#####################################################");
        
        $this->clear();
        $this->startModelMode();
    }

    public function startModelMode()
    {
        match ($this->value) {
            'a' => new Reader(),
            'b' => new Authors(),
        };
    }

    public function askQuestion(string $question, array $expect = []): string 
    {
        $this->printLine($question);
        $this->value = trim(fgets(STDIN));

        // verify the inputs
        if(sizeof($expect) > 0) {
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