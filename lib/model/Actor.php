<?php

require_once './Person.php';

class Actor extends Persona {
    
    private $apellidos;
    private $fotografia;

    public function __construct($id, $username, $apellidos, $fotografia) {
        //Call father constructor
        parent::__construct($id, $username);
        
        $this->apellidos = $apellidos;
        $this->fotografia = $fotografia;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getFotografia() {
        return $this->fotografia;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setFotografia($fotografia) {
        $this->fotografia = $fotografia;
    }
}

