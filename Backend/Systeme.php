<?php

include_once "Utilisateur.php";

class Systeme
{
    private $arrayUtilisateurs = array();  // liste des Utilisateurs


    function __construct()
    {

    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function ajouterUtilisateurInstance(Utilisateur $utilisateur) {

    }
    public function ajouterUtilisateur(string $pseudo, string $prenom, string $nom, string $email, string $mdp) {

        $nouvelUtilisateur = new Utilisateur();  // c'est quoi le SessionID?
        $nouvelUtilisateur->setPseudo($pseudo);
        $nouvelUtilisateur->setPrenom($prenom);
        $nouvelUtilisateur->setNom($nom);
        $nouvelUtilisateur->setEmail($email);
        $nouvelUtilisateur->setMdp($mdp);


        array_push($this->arrayUtilisateurs, $nouvelUtilisateur);

        //Ajouter l'utilisateur à la BDD

    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }
}