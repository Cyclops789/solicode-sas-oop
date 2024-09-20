<?php

// One to One Relationship
// class Personne {
//     private $id;
//     private $nom;
//     private $passeport;

//     public function setPasseport(Passeport $passeport): void {
//         $this->passeport = $passeport;
//         $passeport->setPersonne($this);

//         echo $passeport->getNumero();
//     }

//     public function getPasseport(): Passeport
//     {
//         return $this->passeport;
//     }
// }

// class Passeport {
//     private $numero;
//     private $dateExpiration;
//     private $personne;

//     public function __construct()
//     {
//         $this->numero = random_int(999, 99999);
//     }

//     public function getNumero()
//     {
//         return $this->numero;
//     }


//     public function setPersonne(Personne $personne): void {
//         $this->personne = $personne;
//     }
// }

// $passport = new Passeport();
// $personne = new Personne();

// $personne->setPasseport($passport);





// One to Many Relationship
class Auteur {
    private $id;
    private $nom;
    /** @var Livre[] */
    private $livres = [];

    public function addLivre(Livre $livre): void {
        $this->livres[] = $livre;
        $livre->setAuteur($this);
        echo "Added: ".count($this->livres)."\n";
    }
}

class Livre {
    private $id;
    private $titre;
    private $auteur;


    public function setAuteur(Auteur $auteur)
    {
        $this->auteur = $auteur;
    }
}


$livre = new Livre();
$auteur = new Auteur();

for ($i=0; $i < 5; $i++) { 
    $auteur->addLivre($livre);
}





// Many-to-Many Relationship
// class Etudiant {
//     private $id;
//     private $nom;
//     /** @var Cours[] */
//     private $cours = [];

//     // ... getters et setters ...

//     public function ajouterCours(Cours $cours): void {
//         $this->cours[] = $cours;
//         $cours->ajouterEtudiant($this);
//     }
// }

// class Cours {
//     private $id;
//     private $nom;
//     /** @var Etudiant[] */
//     private $etudiants = [];

//     // ... getters et setters ...

//     public function ajouterEtudiant(Etudiant $etudiant): void {
//         $this->etudiants[] = $etudiant;
//     }
// }






// Using an ORM (Doctrine)
// // Configuration de Doctrine (simplifiée)
// use Doctrine\ORM\EntityManager;

// $entityManager = EntityManager::create(/* ... paramètres de connexion ... */);

// // Création d'un nouvel auteur et de livres associés
// $auteur = new Auteur();
// $auteur->setNom('Dumas');

// $livre1 = new Livre();
// $livre1->setTitre('Les Trois Mousquetaires');
// $livre1->setAuteur($auteur);

// $entityManager->persist($auteur);
// $entityManager->persist($livre1);
// $entityManager->flush();