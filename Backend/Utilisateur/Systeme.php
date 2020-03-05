<?php

include_once "Utilisateur.php"; // This is okay they share the same folder
include_once getenv('BASE')."Backend/DAO/DAOUtilisateur.php";
include_once getenv('BASE')."Shared/Libraries/BDD.php";

class Systeme
{
    private static $bdd = null;
    private static $dao_user = null;
    private static $DEFAULT_DB_FILE = "db.sql";

    public static function Init()
    {
        $bdd = new BDD(self::$DEFAULT_DB_FILE);
        self::$dao_user = new DAOUtilisateur($bdd);
    }

    public function ajouterUtilisateurInstance(Utilisateur $utilisateur) {

    }
    
    public static function ajouterUtilisateur($utilisateur) {
        self::$dao_user->ajouterDansBDD($utilisateur);
    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }

    public static function seConnecter(string $email, string $mdp) : bool {
        $req = self::$dao_user->getByRequete("email LIKE '".$email."' AND mdp LIKE '".$mdp."'");

        if (sizeof($req) != 1){
            return false;
        }

        return true;
    }

    public function seDeconnecter(int $idUtilisateur){
        // a remplir
    }
}

?>