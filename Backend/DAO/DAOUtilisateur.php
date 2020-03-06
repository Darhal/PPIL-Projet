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

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Utilisateur/Utilisateur.php";
include_once getenv('BASE')."Backend/DAO/DAO.php";

class DAOUtilisateur extends DAO
{
    private static $tab_name = "Utilisateur";

    public function __construct($bdd = null)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idUtilisateur" => "INTEGER constraint Utilisateur_pk primary key autoincrement",
                "pseudo" => "varchar not null",
                "nom" => "varchar not null",
                "prenom" => "varchar not null",
                "email" => "varchar not nullL",
                "mdp" => "varchar not null"
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
        $this->BDD->deleteRow($this->tab_name, "idUtilisateur", $utilisateur->id);
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