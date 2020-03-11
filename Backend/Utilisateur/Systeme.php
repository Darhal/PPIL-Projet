<?php

include_once "Utilisateur.php"; // This is okay they share the same folder

include_once getenv('BASE')."Backend/DAO/DAOUtilisateur.php";
include_once getenv('BASE')."Backend/DAO/DAOListeTaches.php";
include_once getenv('BASE')."Backend/DAO/DAOTache.php";
include_once getenv('BASE')."Backend/DAO/DAOMembre.php";
include_once getenv('BASE')."Backend/DAO/DAOInvit.php";

include_once getenv('BASE')."Backend/Invitation/InvitationListeTache.php";
include_once getenv('BASE')."Backend/Taches/ListeTaches.php";
include_once getenv('BASE')."Backend/Taches/Tache.php";
include_once getenv('BASE')."Backend/Membre.php";



include_once getenv('BASE')."Shared/Libraries/BDD.php";

/**
 * Projet Procrast
 * Classe Systeme
 * L'implentation du Design Pattern Facade. Systeme sert de facade entre l'utilisateur et le reste du back-end
 * Intermediare entre la base de données et php pour les donnees qui concernent les extensions de la classe Notification
 * @authors: Omar C, Jonathan P,
 * @date:05/03/2020
 * @version: 1.0
 *
 */
class Systeme
{
	/**
	 * @var BDD
	 */
    private static $bdd = null;

	/**
	 * @var DAOUtilisateur
	 */
    private static $dao_user = null;

	/**
	 * @var DAOListeTaches
	 */
    private static $dao_listeTaches = null;

	/**
	 * @var DAOTache
	 */
    private static $dao_tache = null;

	/**
	 * @var DAOMembre
	 */
    private static $dao_membre = null;

	/**
	 * @var DAOInvit
	 */
    private static $dao_invit = null;

    private static $DEFAULT_DB_FILE = "db.sql";

    public static function Init()
    {
        $bdd = new BDD(self::$DEFAULT_DB_FILE);
        self::$dao_user = new DAOUtilisateur($bdd);
        self::$dao_listeTaches = new DAOListeTaches($bdd);
        self::$dao_tache = new DAOTache($bdd);
        self::$dao_membre = new DAOMembre($bdd);
        self::$dao_invit = new DAOInvit($bdd);
    }

    public static function start_session() {
	    if (session_status() != PHP_SESSION_ACTIVE) {
		    session_start();
	    }
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
        //TODO

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
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        // On stocke les données dans la session
        $_SESSION["logged_in"] = true;
        $_SESSION["id"] = $req['idutilisateur'];
        $_SESSION["username"] = $req['pseudo'];
        $_SESSION["email"] = $req['email'];
		var_dump($_SESSION);
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

    /**
     * Retourne une instance de l'utilisateur qui a l'email donné en argument, ou NULL s'il n'y a pas d'Utilisateur avec cet email
     * @param $email
     * @return Utilisateur|null
     */
    public static function getUserByEmail($email) : Utilisateur
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

    /**
     * Retourne une instance de l'utilisateur qui a l'ID donné en argument, ou NULL s'il n'y a pas d'Utilisateur avec cet ID
     * @param $id
     * @return Utilisateur|null
     */
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


    /**
     *
     * @param string $pseudo
     * @return array
     */
    public static function getUsersByPseudo(string $pseudo): array {

    	if (!isset($pseudo)) {
    		return [];
	    }

    	$req = self::$dao_user->getUsersByPseudo($pseudo);
    	$res_array = array();

	    foreach ($req as $user) {
	        //TODO: pourquoi il remplit pas prenom et non ?
		    $u = new Utilisateur($user["pseudo"], "", "", $user["email"], "");
		    $u->setId($user["idutilisateur"]);

		    array_push($res_array, $u);
    	}

    	return $res_array;
    }


    /**
     * Met à jour les parametres d'un utilisateur dans la BBD
     * @param Utilisateur $utilisateur
     * @return bool
     */
    public static function updateUser(Utilisateur $utilisateur) {

        if (!isset($utilisateur)) {
            return false;
        }

        self::$dao_user->updateBDD($utilisateur, "idUtilisateur == $utilisateur->id AND mdp == '$utilisateur->mdp'");
        return true;
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
            $listeTache = new ListeTaches($req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
            $listeTache->id = $req['idListe'];
        }else{
            $listeTache = new ListeTaches($req['nom'], $req['idUtilisateur'], $req['dateDebut']);
            $listeTache->id = $req['idListe'];
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

	    foreach ($resSQL as $key => $req) {
		    // Si il y a une dateFin on construit avec, si on n'a pas dateFin, on construit sans
		    $listeTache = null;
		    if ($req['dateFin'] != null) {
			    $listeTache = new ListeTaches($req['nom'], $req['idUtilisateur'], $req['dateDebut'], $req['dateFin']);
                $listeTache->id = $req['idListe'];
		    } else {
			    $listeTache = new ListeTaches($req['nom'], $req['idUtilisateur'], $req['dateDebut']);
                $listeTache->id = $req['idListe'];
		    }

		    array_push($res_array, $listeTache);
	    }

	    return $res_array;

    }

	/**
	 * Donne la liste de toutes les liste dont l'utilisateur est membre
	 * @param Utilisateur $user
	 * @return array | null
	 */
    public static function getLists(Utilisateur $user) {

    	if (!isset($user->id)) {
    		return [];
	    }

    	$resSQL = self::$dao_membre->getLists($user->id);
    	$res_array = array();

	    foreach ($resSQL as $item) {
	    	$list = self::getListeTachesByID($item["idListe"]);
	    	if ($list != null) {
	    		array_push($res_array, $list);
		    }
    	}

	    return $res_array;
    }

	/**
     * Donne un tableau contenant tous les membres qui appartiennent à une ListeDeTaches
	 * @param ListeTaches $listeTaches
	 * @return null | array
	 */
    public static function getMembres(ListeTaches $listeTaches) {

	    if (!isset($listeTaches->id)) {
		    return null;
	    }

	    return self::$dao_membre->getUsers($listeTaches->id);
    }

    /**
     * Crée une tache dans une liste de tâche et l'ajoute à la BDD
     * @param string $nom
     * @param ListeTaches $listeTaches
     * @return bool
     */
    public static function createTask(string $nom, ListeTaches $listeTaches) : bool {
        //  TODO: en fait ici il faudrait déclencher une erreur plutôt qu'un return false;
        if(!isset($listeTaches) || !isset($nom)) return false;

        $tache = new Tache($nom, $listeTaches->id);

        return self::$dao_tache->ajouterDansBDD($tache);
    }

    /**
     * Retourne un tableau qui contient toutes les tâches qui appartiennent à la liste de tâche passée en paramettre
     * @param ListeTaches $liste
     * @return array
     */
    public static function getTasks(ListeTaches $liste) : array {
        if(!isset($liste)) return null;

        $resSQL = self::$dao_tache->getByRequete("idListe = $liste->id");
        $res_array = array();

        foreach ($resSQL as $key => $req) {
            $tache = new Tache($req['nom'], $req['idListe']);
            $tache->finie = $req['statut'];
            $tache->id= $req['idTache'];
            $tache->responsable = $req['idResponsable'];

            array_push($res_array, $tache);
        }

        return $res_array;
    }

    /**
     * Retourne la tache associée à l'ID en paramètre
     * @param int $idTache
     * @return array
     */
    public static function getTaskById(int $idTache) : Tache {
        if(!isset($idTache)) return null;

        $resSQL = self::$dao_tache->getByRequete("idTache = $idTache");

        foreach ($resSQL as $key => $req) {
            $tache = new Tache($req['nom'], $req['idListe']);
            $tache->finie = $req['statut'];
            $tache->id = $req['idTache'];
            $tache->responsable = $req['idResponsable'];
        }
        return $tache;
    }


    /**
     * Ajoute une Liste de Taches pour un utilisateur
     * Retourne True si tout s'est bien passé, False sinon
     * @param $nom
     * @param $dateDebut
     * @param $dateFin
     * @param $idUtilisateur
     * @return bool
     */
    public static function createList($nom, $dateDebut, $dateFin, $idUtilisateur){

        if($dateFin == null){
            $liste = new ListeTaches($nom, $idUtilisateur, $dateDebut);
        } else {
            $liste = new ListeTaches($nom, $idUtilisateur, $dateDebut, $dateFin);
        }

        return self::$dao_listeTaches->ajouterDansBDD($liste);
    }

    /**
     * Supprime une invitation
     * @param InvitationListeTache $invitation
     * @return bool
     */
	public static function refuserInvitation(InvitationListeTache $invitation){
	    //TODO: est-ce qu'on doit notifier celui qui a envoyé l'invitation que cette invitation a été refusée ?
		self::$dao_invit->supprimerDeBDD($invitation);

		return true;
	}

    /**
     * Ajoute la personne invitée à la Liste de Taches à laquelle est invitée
     * Supprime l'invitation
     * @param InvitationListeTache $invitation
     * @return bool
     */
    public static function accepterInvitation(InvitationListeTache $invitation){
        $liste = self::getListeTachesByID($invitation->liste);
        $utilisateur = self::getUserByID($invitation->destinataire);
        self::$dao_membre->add($utilisateur, $liste);
        self::$dao_invit->supprimerDeBDD($invitation);

	    return true;
    }

    /**
     * Créer une invitation pour rejoindre une Liste de Taches
     * @param ListeTaches $liste
     * @param Utilisateur $emetteur
     * @param Utilisateur $destinataire
     * @return bool
     */
    public static function inviterUtilisateur(ListeTaches $liste, Utilisateur $emetteur, Utilisateur $destinataire): bool {

    	if (!isset($liste) || !isset($emetteur) || !isset($destinataire)) {
    		return false;
	    }

	    $invitation = new InvitationListeTache("Je t'invite à rejoindre la liste " . $liste->nom, $emetteur->id, $destinataire->id, $liste->id);
		echo "<pre>";
		var_dump($invitation);
		echo "</pre>";
    	self::$dao_invit->ajouterDansBDD($invitation);

    	return true;
    }

    /**
     * Permet de récupérer toutes les invitations en cours qu'un Utilisateur a reçu
     * @param Utilisateur $utilisateur
     * @return array
     */
    public static function getInvitations(Utilisateur $utilisateur) : array {

    	if (!isset($utilisateur)) {
    		return [];
	    }

    	$resSQL = self::$dao_invit->getInvitationsFor($utilisateur);

    	$res_array = array();

	    foreach ($resSQL as $item) {
		    $invitation = new InvitationListeTache($item['message'], $item['emetteur'], $item['destinataire'], $item['idListe']);
		    $invitation->id = $item['id'];

		    array_push($res_array, $invitation);
    	}

    	return $res_array;
    }


    /**
     * Supprime une ListeDeTaches
     * La BDD s'occupe de la suppression des choses liées
     * @param ListeTaches $liste
     * @return bool
     */
    public static function supprimerListe(ListeTaches $liste) : bool {
        if (!isset($liste)) {
            return false;
        }

        return self::$dao_invit->supprimerDeBDD($liste);
    }

    /**
     * Supprime une ListeDeTaches
     * La BDD s'occupe de la suppression des choses liées
     * @param int $idListe
     * @return bool
     */
    public static function supprimerListeByID(int $idListe) : bool {
        if (!isset($idListe)) {
            return false;
        }
        $liste = self::$dao_invit->getListeTachesByID($idListe);

        return self::supprimerListe($liste);

    }


    /**
     * Supprimer une tache
     * La BDD s'occupe de la suppression des choses liées
     * @param $nomTache
     * @return bool
     */
    public static function supprimerTache(int $idTache) : bool {
        if (!isset($idTache)) {
            return false;
        }

        $tache = self::getTaskById($idTache);
        return self::$dao_tache->supprimerDeBDD($tache);
    }

    //---------------------------- FIN ListeTaches---------------------------------



    //---------------------------- Invitations ---------------------------------

    //---------------------------- FIN Invitations ---------------------------------

    //---------------------------- Notifications ---------------------------------
    public static function getNotifications(int $idUtilisateur) : array {
        if (!isset($idUtilisateur)) {
            return null;
        }
        $utilisateur = self::getUserByID($idUtilisateur);


    }

    //---------------------------- FIN Notifications ---------------------------------


}

?>