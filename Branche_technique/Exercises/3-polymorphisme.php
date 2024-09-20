<?php

class Animal {
    public function faireDuBruit() {
        echo "L'animal fait du bruit.\n";
    }
}

class Chien extends Animal {
    public function faireDuBruit() {
        echo "Ouaf !\n";
    }
}

class Chat extends Animal {
    public function faireDuBruit() {
        echo "Miaou !\n";
    }
}

$animaux = [new Chien(), new Chat(), new Animal()];

foreach ($animaux as $animal) {
    $animal->faireDuBruit();
}