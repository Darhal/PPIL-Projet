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

include_once getenv('BASE')."/Shared/Libraries/BDD.php";
include_once getenv('BASE')."/Backend/Utilisateur/Utilisateur.php";
include_once getenv('BASE')."/Backend/DAO/DAO.php";

class DAOUtilisateur extends DAO
{
    private static $tab_name = "Utilisateur";

    public function __construct()
    {
        parent::__construct("users.db");
        $this->BDD->createTable(self::$tab_name,
            array(
                "email" => "TEXT PRIMARY KEY NOT NULL",
                "pseudo" => "TEXT NOT NULL", 
                "prenom" => "TEXT",
                "nom" => "TEXT",
                "mdp" => "TEXT NOT NULL"
            )
        );
    }

    function ajouterDansBDD($utilisateur)
    {
        $attribs = array(
            "pseudo" => $utilisateur->pseudo,
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "email" => $utilisateur->email,
            "mdp" => $utilisateur->mdp
        );
        $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    function supprimerDeBDD($utilisateur)
    {
        // TODO: Implement supprimerDeBDD() method.
    }

    function getUserByEmail($email)
    {
        $res = $this->BDD->fetchResults("Utilisateur", "*", "email = '$email'");
        return $res;
    }

    function getByRequete($requete = "")
    {
        $res = $this->BDD->fetchResults("Utilisateur", "*", $requete);
        return $res;
    }
}

?>