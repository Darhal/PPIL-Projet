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

include Utilisateur::class;
include BDD::class;
class DAOUtilisateur extends DAO
{
    private $tab_name = "Utilisateur";

    function __construct()
    {

    }

    function ajouterDansBDD($utilisateur)
    {
        // TODO: Implement ajouterDansBDD() method.
        $attribs = array(
            "id" => "NULL",
            "pseudo" => $utilisateur->pseudo,
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "email" => $utilisateur->email,
            "mdp" => $utilisateur->mdp
        );
        $bdd = new BDD();
        $bdd::insertRow($this->tab_name,$attribs);
    }

    function supprimerDeBDD($utilisateur)
    {
        // TODO: Implement supprimerDeBDD() method.
    }

    function getByRequete($requete)
    {
        // TODO: Implement getByRequete() method.

    }



    public function getBDD()
    {
        return $this->BDD;
    }
}