<?php

class Usuario implements Serializable {
    private $id;
    private $username;
    private $password;
    private $rol;

    // Constructor
    public function __construct($id, $username, $password, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Implementación de la interfaz Serializable
    public function serialize() {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->rol
        ]);
    }

    public function unserialize($data) {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->rol
        ) = unserialize($data);
    }
}
