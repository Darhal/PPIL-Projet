<?php
/*
 * Projet Procrast
 * Classe DAOUtilisateur
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les donnees qui concernent la classe Utilisateur
 * @author: Ali MIRMOHAMMADI
 * @date:16/02/2020
 * @version: 1.0
 *
 */
include ('Utilisateur.php');
class DAOUtilisateur extends DAO
{
    function __construct()
    {
    }

    function ajouterDansBDD($utilisateur)
    {
        // TODO: Implement ajouterDansBDD() method.
        $ajout = 'INSERT INTO Utilisateur VALUES (NULL,"'.$utilisateur->pseudo.'","'.$utilisateur->nom.'","'.$utilisateur->prenom.'","'.$utilisateur->email.'","'.$utilisateur->mdp.'");';
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