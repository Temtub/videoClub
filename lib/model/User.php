<?php

require_once './Person.php';

class User extends Person {
    private $password;
    private $rol;

    public function __construct($id, $username, $password, $rol) {
        //Contructor of parent
        parent::__construct($id, $username);
        
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}