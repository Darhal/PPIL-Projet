<?php

include_once "Utilisateur.php"; // This is okay they share the same folder

include_once getenv('BASE')."Backend/DAO/DAOUtilisateur.php";
include_once getenv('BASE')."Backend/DAO/DAOListeTaches.php";
include_once getenv('BASE')."Backend/DAO/DAOTache.php";

include_once getenv('BASE')."Shared/Libraries/BDD.php";

class Systeme
{
    private static $bdd = null;
    private static $dao_user = null;
    private static $dao_listeTaches = null;
    private static $dao_tache = null;
    private static $DEFAULT_DB_FILE = "db.sql";

    public static function Init()
    {
        $bdd = new BDD(self::$DEFAULT_DB_FILE);
        self::$dao_user = new DAOUtilisateur($bdd);
        self::$dao_listeTaches = new DAOListeTaches($bdd);
        self::$dao_tache = new DAOTache($bdd);

    }

    //---------------------------- Utilisateur ---------------------------------


    public static function ajouterUtilisateurInstance(Utilisateur $utilisateur) {
        Systeme::ajouterUtilisateur($utilisateur);
    }
    
    public static function ajouterUtilisateur($utilisateur) {
        $res = self::$dao_user->getUserByEmail($utilisateur->email);
        
        if (sizeof($res) != 0){
            return 1;
        }

        self::$dao_user->ajouterDansBDD($utilisateur);
        return 0;
    }

    public static function supprimerUtilisateur(int $utilisateurID) {

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

        $req = self::$dao_user->getByRequete("email LIKE '".$email."' AND mdp LIKE '".$mdp."'");

        if (sizeof($req) != 1){
            return false;
        }

        $req = $req[0];

        if (session_status() == PHP_SESSION_DISABLED) {
            session_start();
        }

        // On stocke les données dans la session
        $_SESSION["logged_in"] = true;
        $_SESSION["id"] = $req['idutilisateur'];
        $_SESSION["username"] = $req['pseudo'];
        $_SESSION["email"] = $req['email'];

        return true;
    }

    public static function estConnecte()
    {
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true;
    }

    public static function seDeconnecter(){
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION["logged_in"] = false;
            unset($_SESSION["id"]);
            unset($_SESSION["username"]);
            unset($_SESSION["email"]);
        }
    }

    public static function getUserByEmail($email)
    {
        if (isset($email)) {
            $email = SQLite3::escapeString($email);
            $email = trim($email);
        }else{
            return null;
        }
    
        $req = self::$dao_user->getUserByEmail($email);

        if (sizeof($req) != 1){
            return null;
        }

        $req = $req[0];
        $user = new Utilisateur($req['pseudo'], $req['prenom'], $req['nom'], $req['email'], $req['mdp']);
        $user->id = $req['idutilisateur'];
        return $user;
    }

    public static function getUserByID($id)
    {
        if (!isset($id)) {
            return null;
        }
    
        $req = self::$dao_user->getUserByID($id);

        if (sizeof($req) != 1){
            return null;
        }

        $req = $req[0];
        $user = new Utilisateur($req['pseudo'], $req['prenom'], $req['nom'], $req['email'], $req['mdp']);
        $user->id = $req['idutilisateur'];
        return $user;
    }


    //---------------------------- ListeTaches---------------------------------

    /**
     * On donne un numero d'identifiant d'une listeDeTaches et cette fonction retourne l'obj de la ListeTaches
     * Retourne null s'il n'existe pas de liste de tache
     * @param int $id
     * @return ListeTaches|null
     */
    public static function getListeTachesByID(int $id){
        if(!isset($id) || $id<0) return null;

        // On récupère le retour de la requete sql
        $resSQL = self::$dao_listeTaches->getListeTachesByID($id);

        if (sizeof($resSQL) != 1){
            return null;
        }

        $req = $resSQL[0];

        // Si il y a une dateFin on construit avec, si on n'a pas dateFin, on construit sans
        $listeTache = null;
        if($req['dateFin'] !=null){
            $listeTache = new ListeTaches($req['idListe'], $req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
        }else{
            $listeTache = new ListeTaches($req['idListe'], $req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
        }

        return $listeTache;

    }


    /**
     * Retourne un Array de toutes les Listes de Taches d'un Utilisateur
     * @param Utilisateur $user
     * @return array|null
     */
    public static function getOwnedLists(Utilisateur $user)
    {
	    //TODO: testing
	    if (!isset($user->id)) return null;
	    $resSQL = self::$dao_listeTaches->getListesTachesByUserID($user->id);

	    $res_array = array();

	    foreach ($res_array as $key => $req) {
		    // Si il y a une dateFin on construit avec, si on n'a pas dateFin, on construit sans
		    $listeTache = null;
		    if ($req['dateFin'] != null) {
			    $listeTache = new ListeTaches($req['idListe'], $req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
		    } else {
			    $listeTache = new ListeTaches($req['idListe'], $req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
		    }

		    array_push($res_array, $listeTache);
	    }

	    return $res_array;

    }

    /**
     * Crée une tache dans une liste de tâche et l'ajoute à la BDD
     * @param string $nom
     * @param ListeTaches $listeTaches
     * @return bool
     */
    public static function createTask(string $nom, ListeTaches $listeTaches) : boolean {
        //  TODO: en fait ici il faudrait déclencher une erreur plutôt qu'un return false;
        if(!isset($listeTaches) || !isset($nom)) return false;

        $tache = new Tache($nom, $listeTaches);

        //TODO: retour valeur booléenne
        self::$dao_tache->ajouterDansBDD($tache);
        return false;
    }
}

?>