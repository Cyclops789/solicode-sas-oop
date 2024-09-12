<?php

class Voiture {
    public $marque;
    public $modele;
    public $couleur;

    public function __construct()
    {

    }

    public function demarrer() {
        echo "La voiture démarre.";
    }
}

class Car extends Voiture {
    public function __construct()
    {
        $this->marque = "s";
    }
}

$maVoiture = new Voiture();

$maVoiture->marque = "Renault";
$maVoiture->modele = "Clio";
$maVoiture->couleur = "Bleu";

$maVoiture->demarrer();