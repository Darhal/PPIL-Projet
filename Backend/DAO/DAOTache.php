<?php
/*
 * Projet Procrast
 * Classe DAOTache
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les données qui concernent la classe Tache
 * @author: Jonathan Pierrel & Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Taches/Tache.php";
include_once getenv('BASE')."Backend/Utilisateur/Utilisateur.php";
include_once getenv('BASE')."Backend/Taches/ListeTaches.php";


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
    public function ajouterDansBDD($tache) : bool {

        $attribs = array(
//            "idTache" => $tache->id,   // l'id est généré par la BDD
            "nom" => $tache->nom,
            "statut" => $tache->finie,
            "idListe" => $tache->idListe
        );

        if($tache->responsable != null){
            $attribs["idResponsable"] = $tache->responsable->id;
        }

        return $this->BDD->insertRow(self::$tab_name, $attribs);

    }
    public function ajouterIdResponsable($idUtilisateur, $tache)
    {

    }

    public function supprimerDeBDD($tache) : bool {
        return $this->BDD->deleteRow(self::$tab_name, "idTache = ".$tache->id);
    }

    public function getByRequete($requete) : array {
        return $this->BDD->fetchResults("Tache", "*", $requete);
    }


    public function updateBDD($tache, $condition = "") : bool
    {
        $attribs = array();
        // TODO: JUST FINISH THIS (Look at DAOUtilisateur and get some inspiration from there)
        $attribs = array(
            "idTache" => $tache->id,
            "nom" => $tache->nom,
            "statut" => ($tache->finie)?1:0,
            "idListe" => $tache->idListe,
            "idResponsable" => $tache->responsable
        );
        $res = $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
        return $res;
    }

	public function update(Tache $task) {
    	return $this->updateBDD($task, "idTache == $task->id");
	}
}