<?php

require_once 'UserModel.php';

class UserService extends User {
    public $nom, $email;

    public function addUser() {
        return $this->insertUser($this->nom, $this->email);
    }

    public function getUsers() {
        return $this->fetchUsers();
    }
}