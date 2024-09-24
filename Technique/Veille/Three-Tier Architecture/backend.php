<?php

require_once 'UserService.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    $service = new UserService();
    $service->nom = $nom;
    $service->email = $email;
    $service->addUser();
    
    header('Location: /');
}
?>