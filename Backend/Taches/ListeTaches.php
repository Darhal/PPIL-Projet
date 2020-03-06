<?php


class ListeTaches
{
    public $id;
    public $nom;
    public $dateDebut;
    public $dateFin;
    public $proprietaire;

    public function __construct($id, $nom, $proprietaire, $dateDebut, $dateFin="vide")
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->proprietaire = $proprietaire;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

}

?>