<?php

class Utilisateur {
    private $nom;
    private $prenom;
    private $email;

    public function __construct($nom, $prenom, $email) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
}

$user = new Utilisateur("Hamza", "Jarane", "tes@ssa.com");

$user->setNom("test");

echo($user->getNom());