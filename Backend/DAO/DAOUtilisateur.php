<?php
/*
 * Projet Procrast
 * Classe DAOUtilisateur
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les donnees qui concernent la classe Utilisateur
 * @author: Omar CHIDA & Ali MIRMOHAMMADI & Louy MASSET
 * @date:16/02/2020
 * @version: 1.0
 *
 */
set_include_path(getenv('BASE'));
include_once "Shared/Libraries/BDD.php";
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/DAO/DAO.php";

class DAOUtilisateur extends DAO
{
    private static $tab_name = "Utilisateur";

    public function __construct($bdd = null)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idutilisateur" => "INTEGER PRIMARY KEY AUTOINCREMENT",
                "email" => "TEXT UNIQUE NOT NULL",
                "pseudo" => "TEXT NOT NULL", 
                "prenom" => "TEXT",
                "nom" => "TEXT",
                "mdp" => "TEXT NOT NULL"
            )
        );
    }

    function ajouterDansBDD($utilisateur) : bool
    {
        $attribs = array(
            "pseudo" => $utilisateur->pseudo,
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "email" => $utilisateur->email,
            "mdp" => $utilisateur->mdp
        );
        return $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    function supprimerDeBDD($utilisateur) : bool
    {
        return $this->BDD->deleteRow(self::$tab_name, "idUtilisateur = ".$utilisateur->id);
    }

    function supprimerDeBDDByID($idUser) : bool
    {
        return $this->BDD->deleteRow(self::$tab_name, "idUtilisateur = ".$idUser);
    }

    function getUserByEmail($email) : array
    {
	    return $this->getByRequete("email = '$email'");
    }

    function getUserByID($id) : array
    {
	    return $this->getByRequete("idutilisateur = '$id'");
    }

    function getByRequete($requete = "") : array
    {
	    return $this->BDD->fetchResults("Utilisateur", "*", $requete);
    }

    public function updateBDD($utilisateur, $condition = "") : bool
    {
        $attribs = array(
            "pseudo" => $utilisateur->pseudo,
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "email" => $utilisateur->email,
            "mdp" => $utilisateur->mdp
        );

        return $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
    }

    function getUsersByPseudo($pseudo) : array {
	    return $this->getByRequete("pseudo LIKE '%" . SQLite3::escapeString($pseudo) . "%'");
    }
}

