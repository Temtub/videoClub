<?php

class Pelicula {

    private $id;
    private $titulo;
    private $genero;
    private $pais;
    private $anyo;
    private $cartel;
    private $Reparto;


    public function __construct($id, $titulo, $genero, $pais, $anyo, $cartel) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        $this->cartel = $cartel;
        
        //array of actors from the movie
        $this->Reparto = array();
    }
    
    /**
     * Function to save an actor in the the array of 
     * 
     * @param Actor $actor <p>Actor you want to add in the array</p>
     */
    function addActorReparto($actor){
        
        array_push($this->Reparto, $actor);
    }
    
    //Getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getAnyo() {
        return $this->anyo;
    }

    public function getCartel() {
        return $this->cartel;
    }
    
    //Setters

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setGenero($genero): void {
        $this->genero = $genero;
    }

    public function setPais($pais): void {
        $this->pais = $pais;
    }

    public function setAnyo($anyo): void {
        $this->anyo = $anyo;
    }

    public function setCartel($cartel): void {
        $this->cartel = $cartel;
    }

}
