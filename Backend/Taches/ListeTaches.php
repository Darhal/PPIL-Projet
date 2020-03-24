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

    public function formattedDebut(): string {
    	return $this->formattedDate($this->dateDebut);
    }

    public function formattedFin() : string {
	    return $this->formattedDate($this->dateFin);
    }

    private function formattedDate($date) : string {

    	if ($date == "NULL" || $date == "") {
    		return "Aucune";
	    }
    	return date("d/m/y", intval($date));
    }

    private function placeholder($date) : string {
	    if ($date == "NULL" || $date == "") {
		    return "";
	    }
	    return date("Y-m-d", intval($date));
    }

    public function placeholderDebut() : string {
    	return $this->placeholder($this->dateDebut);
    }

	public function placeholderFin() : string {
		return $this->placeholder($this->dateFin);
	}

}

