<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Utilisateur.php";

class Tache
{

    public $id;
    public $nom;
    public $finie;
    public $responsable;//int
    public $idListe;

    function __construct(string $n, int $idListe)
    {
        $this->nom = $n;
        $this->finie = false;
        $this->idListe = $idListe;
    }

    //Setters
    public function setFait(bool $f) {
        $this->finie = $f;
    }


    //Getters
    public function getId() : int {
        return $this->id;
    }

    public function getNom() : string {
        return $this->nom;
    }

    public function getResponsable() {
        return $this->responsable;
    }

    public function estFinie() : bool {
        return $this->finie;
    }

    public function aUnResponsable() : bool {
        return $this->responsable != null;
    }


    //Fonctions
    public function ajouterResponsable(Utilisateur $utilisateur) {
        $this->responsable = $utilisateur->id;
    }

    public function supprimerResponsable() {
        $this->responsable = null;
    }

}

?>