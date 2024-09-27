<?php

namespace App\Realisation\Managers;

enum Colors: string
{
    case YELLOW = "\e[93m";
    case BLUE = "\e[34m";
    case RED = "\e[91m";
    case GREEN = "\e[32m";
    case DEFAULT = "\e[39m";
}

abstract class Console
{
    protected string $value;
    protected array $expect;

    public function separator()
    {
        $this->printLine("#################################################", "blue");
    }

    public function askQuestion(string $question, array $expect = []): string
    {
        $this->printLine($question, "yellow");
        $this->value = trim(fgets(STDIN));

        if ($this->value === 'exit') {
            die(0);
        }

        // verify the inputs
        if (sizeof($expect) > 0) {
            $expect = [...$expect, 'back'];
            $found = false;
            foreach ($expect as $expected) {
                if ($this->value === $expected) {
                    $found = true;
                }
            }

            if (!$found) {
                die("Invalid value");
            }
        }

        return $this->value;
    }

    public function clear()
    {
        echo "\033[2J\033[;H";
    }

    /**
     * @param string $line
     * @param string $color default, yellow, blue, red, green
     * @return void
     */
    public function printLine(string $line, string $color = "default")
    {
        $colorValue = match ($color) {
            "red" => Colors::RED->value,
            "blue" => Colors::BLUE->value,
            "yellow" => Colors::YELLOW->value,
            "green" => Colors::GREEN->value,
            default => Colors::DEFAULT ->value,
        };

        echo $colorValue . $line . "\n" . Colors::DEFAULT ->value;
    }

    public function printOption(string $optionName, string $optionValue)
    {
        echo Colors::RED->value . "[" . Colors::YELLOW->value . $optionValue . Colors::RED->value . "] - " . Colors::DEFAULT ->value . $optionName . "\n" . Colors::DEFAULT ->value;
    }

    public static function getID(): int
    {
        return random_int(1000, 9999);
    }

    public static function getDate(int $addDays = 0): string
    {
        if ($addDays > 0) {
            return date("F j, Y, g:i a", strtotime(date("F j, Y, g:i a") . " + {$addDays} days"));
        }
        return date("F j, Y, g:i a");
    }
}