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

// echo($user->getNom());

class CompteBancaire {
    private $solde;

    public function __construct($soldeInitial) {
        $this->solde = $soldeInitial;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function deposer($montant) {
        if ($montant > 0) {
            $this->solde += $montant;
        } else {
            echo "Le montant doit être positif.";
        }
    }

    public function retirer($montant) {
        if ($montant <= $this->solde) {
            $this->solde -= $montant;
        } else {
            echo "Solde insuffisant.";
        }
    }
}

$account = new CompteBancaire(40);

echo($account->getSolde());

$account->deposer(50);

echo($account->getSolde());