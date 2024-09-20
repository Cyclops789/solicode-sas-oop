<?php

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=test', 'hamza', '123');
    }

    public function insertUser($nom, $email) {
        $sql = "INSERT INTO utilisateurs (nom, email) VALUES (:nom, :email)";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
    }

    public function fetchUsers()
    {
        $sql = "SELECT * FROM utilisateurs";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>