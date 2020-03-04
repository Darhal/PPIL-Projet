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

include_once getenv('PROJECT_PATH')."/Utilisateur.php";
include_once "DAO.php";
include_once "../../Assets/BD/BDD.php";

class DAOUtilisateur extends DAO
{
    private $tab_name = "Utilisateur";

    function ajouterDansBDD($utilisateur)
    {
        $attribs = array(
            "id" => "NULL",
            "pseudo" => $utilisateur->pseudo,
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "email" => $utilisateur->email,
            "mdp" => $utilisateur->mdp
        );
        $bdd = new BDD("BD.sqlite");
        $bdd->insertRow($this->tab_name,$attribs);
    }

    function supprimerDeBDD($utilisateur)
    {
        // TODO: Implement supprimerDeBDD() method.
    }

    public function getByRequete($requete)
    {
        $bdd = new BDD("BD.sqlite");
        $res = $bdd->fetchResults("Utilisateur","*",$requete);
        return $res;
    }



    public function getBDD()
    {
        return $this->BDD;
    }
}