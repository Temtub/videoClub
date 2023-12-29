<?php

class Pelicula implements Serializable{

    private $id;
    private $titulo;
    private $genero;
    private $pais;
    private $anyo;
    private $cartel;
    private $reparto;


    public function __construct($id, $titulo, $genero, $pais, $anyo, $cartel) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        $this->cartel = $cartel;
        
        //array of actors from the movie
        $this->reparto = array();
    }
    
    /**
     * Function to save an actor in the the array of 
     * @param Actor $actor <p>Actor you want to add in the array</p>
     */
    function addActorReparto($actor){
        
        array_push($this->reparto, $actor);
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
    
    public function getReparto() {
        return $this->reparto;
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

    //Functions to make the object serializable
    public function serialize() {
        return serialize([
            $this->id,
            $this->titulo,
            $this->genero,
            $this->pais,
            $this->anyo,
            $this->cartel,
            $this->reparto
        ]);
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->titulo,
            $this->genero,
            $this->pais,
            $this->anyo,
            $this->cartel,
            $this->reparto
        ) = unserialize($serialized);
    }
}
