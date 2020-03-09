<?php
/*
 * Projet Procrast
 * Classe DAOTache
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les données qui concernent la classe Tache
 * @author: Jonathan Pierrel
 * @date:05/03/2020
 * @version: 1.0
 *
 */

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Taches/Tache.php";


class DAOTache extends DAO
{
    private static $tab_name = "Tache";

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idTache" => "INTEGER constraint Tache_pk primary key autoincrement",
                "nom" => "varchar not null",
                "statut" => "varchar not null",
                "idListe" => "INTEGER not null references Liste",
	            "idResponsable" => "INTEGER references Utilisateur"
            )
        );
    }

    //TODO: il faut retourner un booléen en fonction de si ça s'est bien passé!
    public function ajouterDansBDD($tache) {

        $attribs = array(
//            "idTache" => $tache->id,   // l'id est généré par la BDD
            "nom" => $tache->nom,
            "statut" => $tache->finie,
            "idListe" => $tache->idListe
        );

        if($tache->responsable != null){
            $attribs["idResponsable"] = $tache->responsable->id;
        }

        $this->BDD->insertRow(self::$tab_name, $attribs);

    }

    public function supprimerDeBDD($tache){
        $this->BDD->deleteRow($this->tab_name, "idTache = ".$tache->id);
    }

    public function getByRequete($requete){
        return $this->BDD->fetchResults("Tache", "*", $requete);;
    }

    public function updateBDD($attribs, $condition)
    {
        $res = $this->BDD->updateRow($tab_name, $attribs, $condition);
        return $res;
    }
}