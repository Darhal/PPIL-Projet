<?php


class Tache
{

    public $id;
    public $nom;
    public $finie;
    public $responsable;
    public $idListe;

    function __construct(Utilisateur $u, int $i, string $n, int $idListe)
    {
        $this->responsable = $u;
        $this->id = $i;
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

    public function getResponsable() : Utilisateur {
        return $this->responsable;
    }

    public function estFinie() : bool {
        return $this->finie;
    }

    public function aUnResponsable() : bool {
        return isset($this->responsable);
    }


    //Fonctions
    public function ajouterResponsable(int $i) {
        $this->responsable = DAOUtilisateur::getUserById($i);
    }

    public function supprimerResponsable() {
        $this->responsable = null;
    }

}

?>