<?php


class Tache
{

    private $id;
    private $nom;
    private $finie;
    private $responsable;
    private $idListe;

    function __construct(Utilisateur $u, int $i, string $n, int $idListe)
    {
        $this->responsable = $u;
        $this->id = $i;
        $this->nom = $n;
        $this->finie = false;
        $this->idListe = $idListe;

    }

    //Setters
    function setFait(bool $f) {
        $this->finie = $f;
    }


    //Getters
    function getId() : int {
        return $this->id;
    }

    function getNom() : string {
        return $this->nom;
    }

    function getResponsable() : Utilisateur {
        return $this->responsable;
    }

    function estFinie() : bool {
        return $this->finie;
    }

    function aUnResponsable() : bool {
        return isset($this->responsable);
    }


    //Fonctions
    function ajouterResponsable(int $i) {
        $this->responsable = DAOUtilisateur::getUserById($i);
    }

    function supprimerResponsable() {
        $this->responsable = null;
    }

}

?>