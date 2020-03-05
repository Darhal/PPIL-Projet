<?php

include_once "Utilisateur.php"; // This is okay they share the same folder
include_once getenv('PROJECT_PATH')."/Backend/DAO/DAOUtilisateur.php";

class Systeme
{
    private $arrayUtilisateurs = array();  // liste des Utilisateurs
    private static $dao = null;

    public static function Init()
    {
        self::$dao = new DAOUtilisateur();
    }

    public function ajouterUtilisateurInstance(Utilisateur $utilisateur) {

    }
    
    public static function ajouterUtilisateur($utilisateur) {
        self::$dao->ajouterDansBDD($utilisateur);
    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }

    public static function seConnecter(string $email, string $mdp) : bool {
        $req = self::$dao->getByRequete("email LIKE '".$email."' AND mdp LIKE '".$mdp."'");

        if (sizeof($req) == 0){
            return false;
        }

        return true;
    }

    public function seDeconnecter(int $idUtilisateur){
        // a remplir
    }
}

?>