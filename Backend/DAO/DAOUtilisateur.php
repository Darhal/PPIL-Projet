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

include_once getenv('PROJECT_PATH')."/Shared/Libraries/BDD.php";
include_once getenv('PROJECT_PATH')."/Backend/Utilisateur/Utilisateur.php";
include_once getenv('PROJECT_PATH')."/Backend/DAO/DAO.php";

class DAOUtilisateur extends DAO
{
    private $tab_name = "Utilisateur";

    function __construct()
    {
        parent::__construct("users.db");
        $this->BDD->createTable($this->tab_name,
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
            "pseudo" => $utilisateur->getPseudo(),
            "nom" => $utilisateur->getNom(),
            "prenom" => $utilisateur->getPrenom(),
            "email" => $utilisateur->getEmail(),
            "mdp" => $utilisateur->getMdp()
        );
        $this->BDD->insertRow($this->tab_name, $attribs);
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