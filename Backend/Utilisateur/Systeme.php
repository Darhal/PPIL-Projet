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
        $res = self::$dao_user->getUserByEmail($utilisateur->email);
        
        if (sizeof($res) != 0){
            return 1;
        }

        self::$dao_user->ajouterDansBDD($utilisateur);
        return 0;
    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }

    public static function seConnecter(string $email, string $mdp) : bool {
        if (isset($email)) {
            $email = SQLite3::escapeString($email);
            $email = trim($email);
        }else{
            return false;
        }
    
        if (isset($mdp)) {
            $mdp = SQLite3::escapeString($mdp);
            $mdp = trim($mdp);
        }else{
            return false;
        }

        $req = self::$dao_user->getByRequete("email LIKE '".$email."' AND mdp LIKE '".$mdp."'")[0];

        if (sizeof($req) != 1){
            return false;
        }

        if (session_status() == PHP_SESSION_DISABLED) {
            session_start();
        }

        // On stocke les données dans la session
        $_SESSION["logged_in"] = true;
        $_SESSION["id"] = $req['email'];
        $_SESSION["username"] = $req['pseudo'];

        return true;
    }

    public static function estConnecte()
    {
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true;
    }

    public function seDeconnecter(int $idUtilisateur){
        // a remplir
    }
}

?>