<?php

// Example 1
class Livre {
    public $titre;
    public $isbn;
    public $auteurs;
}

class Auteur {
    public $nom;
    public $prenom;
}

// Example 2
$livre1 = new Livre();
$livre1->titre = "Le Petit Prince";
$livre1->isbn = "9782266000016";
$livre1->auteurs = [
    new Auteur("Saint-Exupéry", "Antoine de")
];

// Example 3
$json = json_encode($livre1, JSON_PRETTY_PRINT);
echo $json;

// Example 4
file_put_contents('serialization.json', $json);