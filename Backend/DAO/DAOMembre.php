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
set_include_path(getenv('BASE'));
include_once "Shared/Libraries/BDD.php";
include_once "Backend/Taches/ListeTaches.php";
include_once "Backend/Membre.php";


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

    public function ajouterDansBDD($membre) : bool{
        $attribs = array(
            "idListe" => $membre->idListe,
            "idUtilisateur" => $membre->idUtilisateur
        );

        return $this->BDD->insertRow(self::$tab_name, $attribs);
    }


    public function supprimerDeBDD($membre) : bool{
        return $this->BDD->deleteRow(self::$tab_name, "idListe = $membre->idListe AND idUtilisateur = $membre->idUtilisateur");
    }

    public function getByRequete($requete) : array{
        return $this->BDD->fetchResults(self::$tab_name, "*", $requete);
    }

	/**
	 * @param int $id ID de l'utilisateur
	 * @return array
	 */
    public function getLists(int $id) : array
    {
	    return $this->getByRequete("idUtilisateur = $id");
    }

	/**
	 * @param int $id ID de la liste
	 * @return array
	 */
    public function getUsers(int $id) : array
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

    public function add(Utilisateur $user, ListeTaches $liste) : bool{
		$membre = new Membre($liste->id, $user->id);
		return $this->ajouterDansBDD($membre);
    }

	public function delete(Utilisateur $user, ListeTaches $liste) : bool {
		$membre = new Membre($liste->id, $user->id);
		return $this->supprimerDeBDD($membre);
	}

    public function updateBDD($membre, $condition = "") : bool
    {
        $attribs = array(); // TODO: JUST FINISH THIS (Look at DAOUtilisateur and get some inspiration from there)
	    return $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
    }
}