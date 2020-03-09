<?php


class ListeTaches
{
    public $id;
    public $nom;
    public $dateDebut;
    public $dateFin;
    public $proprietaire;

    public function __construct($nom, $proprietaire, $dateDebut, $dateFin="NULL")
    {
        $this->nom = $nom;
        $this->proprietaire = $proprietaire;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

}

?>