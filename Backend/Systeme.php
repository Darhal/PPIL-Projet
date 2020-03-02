<?php

include_once "Utilisateur.php";
include_once "Backend/DAO/DAOUtilisateur.php";
class Systeme
{
    private $arrayUtilisateurs = array();  // liste des Utilisateurs
    private static $instance = null;


    private function __construct()
    {

    }

    private function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new Systeme();
        }
        return self::$instance;
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
        $dao = DAOUtilisateur::getInstance();
        $dao->ajouterDansBDD($nouvelUtilisateur);

    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }

    public function seConnecter(string $email, string $mdp) : bool {
        $res = false;

        $dao = DAOUtilisateur::getInstance();
        $req = $dao->getByRequete("email LIKE " . $email . "AND mdp LIKE " . $mdp);

        // a remplir
        // chercher dans la BDD l'utilisateur

        return $res;

    }

    public function seDeconnecter(int $idUtilisateur){
        // a remplir
    }


}