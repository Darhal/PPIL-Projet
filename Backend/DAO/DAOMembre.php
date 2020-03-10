<?php
/*
 * Projet Procrast
 * Classe DAOListeTaches
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les donnees qui concernent la classe ListeTaches
 * @author: Jonathan Pierrel
 * @date:05/03/2020
 * @version: 1.0
 *
 */

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Taches/ListeTaches.php";
include_once getenv('BASE')."Backend/Membre.php";


class DAOMembre extends DAO
{
    private static $tab_name = "Membre";

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idListe" => "INTEGER constraint Membre_Liste_idListe_fk references Liste",
                "idUtilisateur" => "int constraint Membre_Utilisateur_idUtilisateur_fk references Utilisateur"
            )
        );
    }

    public function ajouterDansBDD($membre){
        $attribs = array(
            "idListe" => $membre->idListe,
            "idUtilisateur" => $membre->idUtilisateur
        );

        return $this->BDD->insertRow(self::$tab_name, $attribs);
    }


    public function supprimerDeBDD($membre){
        return $this->BDD->deleteRow(self::$tab_name, "idListe = " . $membre->liste);
    }

    public function getByRequete($requete){
        return $this->BDD->fetchResults(self::$tab_name, "*", $requete);;
    }

	/**
	 * @param int $id ID de l'utilisateur
	 * @return array
	 */
    public function getLists(int $id)
    {
	    return $this->getByRequete("idUtilisateur = $id");
    }

	/**
	 * @param int $id ID de la liste
	 * @return array
	 */
    public function getUsers(int $id)
    {
        $resSQL =  $this->getByRequete("idListe = $id");

        $res_array = array();

        foreach ($resSQL as $res) {
        	$uid = $res['idUtilisateur'];
        	$user = Systeme::getUserByID($uid);

        	if ($user != null) {
        		array_push($res_array, $user);
	        }
        }

	    return $res_array;
    }

    public function add(Utilisateur $user, ListeTaches $liste) {
		$membre = new Membre($liste->id, $user->id);
		return $this->ajouterDansBDD($membre);
    }

    public function updateBDD($membre, $condition = "")
    {
        $attribs = array(); // TODO: JUST FINISH THIS (Look at DAOUtilisateur and get some inspiration from there)
        $res = $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
        return $res;
    }
}