<?php
set_include_path(getenv('BASE'));

include_once "Utilisateur.php"; // This is okay they share the same folder

include_once "Backend/DAO/DAOUtilisateur.php";
include_once "Backend/DAO/DAOListeTaches.php";
include_once "Backend/DAO/DAOTache.php";
include_once "Backend/DAO/DAOMembre.php";
include_once "Backend/DAO/DAOInvit.php";
include_once "Backend/DAO/DAONotif.php";

include_once "Backend/Invitation/InvitationListeTache.php";
include_once "Backend/Taches/ListeTaches.php";
include_once "Backend/Taches/Tache.php";
include_once "Backend/Membre.php";

include_once "Shared/Libraries/BDD.php";

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
    /**
     * @var DAONotif
     */
    private static $dao_notif = null;

    private static $DEFAULT_DB_FILE = "db.sqlite";

    public static function Init()
    {
        $bdd = new BDD(self::$DEFAULT_DB_FILE);
        self::$dao_user = new DAOUtilisateur($bdd);
        self::$dao_listeTaches = new DAOListeTaches($bdd);
        self::$dao_tache = new DAOTache($bdd);
        self::$dao_membre = new DAOMembre($bdd);
        self::$dao_invit = new DAOInvit($bdd);
        self::$dao_notif = new DAONotif($bdd);
    }

    public static function start_session() {
	    if (session_status() != PHP_SESSION_ACTIVE) {
		    session_start();
	    }
    }

	/**
	 * Permet de récupérer, en toute sécurité, une valeur dans le POST
	 * @param $key string la clé de la valeur à récupérer
	 * @return bool | string
	 */
    public static function _POST(string $key) {

    	if (!isset($_POST[$key])) {
    		error_log("La clé '$key'' n'est pas définie dans le POST");
    	    return false;
	    }

    	$rawValue = $_POST[$key];
	    /** @noinspection PhpUnnecessaryLocalVariableInspection */
	    $escapedValue = SQLite3::escapeString($rawValue);

    	return $escapedValue;
    }

	/**
	 * Permet de récupérer, en toute sécurité, une valeur dans le GET
	 * @param $key string la clé de la valeur à récupérer
	 * @return bool | string
	 */
	public static function _GET(string $key) {

		if (!isset($_GET[$key])) {
			error_log("La clé '$key'' n'est pas définie dans le GET");
			return false;
		}

		$rawValue = $_GET[$key];
		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		$escapedValue = SQLite3::escapeString($rawValue);

		return $escapedValue;
	}

    //---------------------------- Utilisateur ---------------------------------


    /**
     * Permet d'ajouter une instance d'un Utilisateur
     * @param Utilisateur $utilisateur
     */
    public static function ajouterUtilisateurInstance(Utilisateur $utilisateur) {
        Systeme::ajouterUtilisateur($utilisateur);
    }

	/**
	 * @param Utilisateur $utilisateur Un utilisateur
	 * @return int 1 si un utilisateur possède déjà le mail passé, 0 si tout va bien
	 */
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

    /**
     * Permet qu'un Utilisateur se connecte
     * @param string $email
     * @param string $mdp
     * @return bool
     */
    public static function seConnecter(string $email, string $mdp) : bool {
        if (isset($email)) {
            $email = SQLite3::escapeString($email);
        }else{
            return false;
        }
    
        if (isset($mdp)) {
            $mdp = SQLite3::escapeString($mdp);
        }else{
            return false;
        }

        $req = self::$dao_user->getByRequete("email = '".$email."' AND mdp = '".$mdp."'");

        if (sizeof($req) != 1){
            return false;
        }

        $req = $req[0];
        self::start_session();

        // On stocke les données dans la session
        $_SESSION["logged_in"] = true;
        $_SESSION["id"] = $req['idutilisateur'];
        $_SESSION["username"] = $req['pseudo'];
        $_SESSION["email"] = $req['email'];
		var_dump($_SESSION);
        return true;
    }

    /**
     * Permet de vérifier si un Utilisateur est connecté
     * @return bool
     */
    public static function estConnecte()
    {
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true;
    }

    /**
     * Permet de deconnecter un Utilisateur
     */
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
    public static function getUserByEmail($email)
    {
        if (isset($email)) {
            $email = SQLite3::escapeString($email);
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
	        //TODO: pourquoi il remplit pas prenom et non ? -> par sécurité
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

	    if (!filter_var($utilisateur->email, FILTER_VALIDATE_EMAIL)) {
		    return false;
	    }

        self::$dao_user->updateBDD($utilisateur, "idUtilisateur = $utilisateur->id AND mdp = '$utilisateur->mdp'");
        return true;
    }

    /**
     * Permet de modifier le mdp d'un Utilisateur
     * @param Utilisateur $user
     * @param string $old_password
     * @param string $new_password
     * @return bool
     */
	public static function changePassword(Utilisateur $user, string $old_password, string $new_password) {

    	$old_password = SQLite3::escapeString($old_password);
		$new_password = SQLite3::escapeString($new_password);

    	if (!isset($user) || !isset($old_password) || !isset($new_password)) {
    		return false;
	    }

    	// le nouveau mot de passe doit être différent de l'ancien
    	if ($old_password == $new_password) {
    		return false;
	    }

    	// si l'utilisateur n'a pas donné le bon mdp avant le changement
        // BUG : pb ici
//    	if ($user->mdp != $old_password) {
//    		return false;
//	    }

        $user->mdp = $new_password;

    	return self::$dao_user->updateBDD($user, "idUtilisateur = $user->id");
	}

    //---------------------------- FIN Utilisateur ---------------------------------


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
	    	$liste = Systeme::getListeTachesByID($req['idListe']);
		    array_push($res_array, $liste);
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
     * Donne un tableau contenant tous les membres invités qui appartiennent à une ListeDeTaches
	 * @param ListeTaches $listeTaches
	 * @return null | array
	 */
    public static function getMembresInvites(ListeTaches $listeTaches) {

	    if (!isset($listeTaches->id)) {
		    return [];
	    }

	    return self::$dao_membre->getUsers($listeTaches->id);
    }

	/**
	 * Donne un tableau contenant tous les membres qui appartiennent à une ListeDeTaches
	 * @param ListeTaches $listeTaches
	 * @return null | array
	 */
	public static function getMembres(ListeTaches $listeTaches) {

		if (!isset($listeTaches->id)) {
			return [];
		}

		$membres = self::getMembresInvites($listeTaches);
		$proprietaire = Systeme::getUserByID($listeTaches->proprietaire);
		array_unshift($membres, $proprietaire);

		return $membres;
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

	    $nom = SQLite3::escapeString($nom);

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
     * Supprime une ListeDeTaches
     * La BDD s'occupe de la suppression des choses liées
     * @param ListeTaches $liste
     * @return bool
     */
    public static function supprimerListe(ListeTaches $liste) : bool {
        if (!isset($liste)) {
            return false;
        }

        return self::$dao_listeTaches->supprimerDeBDD($liste);
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
        $liste = self::getListeTachesByID($idListe);

        return self::supprimerListe($liste);

    }

    /**
     * Met à jour une liste dans la BDD
     * @param ListeTaches $liste
     * @return bool
     */
    public static function updateList(ListeTaches $liste) : bool {
        var_dump($liste);
        return self::$dao_listeTaches->update($liste);
    }

    /**
     * Permet de retirer un Utilisateur d'une liste
     * @param Utilisateur $utilisateur
     * @param ListeTaches $listeTaches
     * @return bool
     */
	public static function quitterListe(Utilisateur $utilisateur, ListeTaches $listeTaches) : bool {
		return self::$dao_membre->delete($utilisateur, $listeTaches);
	}

    /**
     * Permet de rechercher en donnant un pseudo les membres qui n'appartiennent pas à une liste
     * @param string $pseudo
     * @param ListeTaches $listeTaches
     * @return array
     */
	public static function getUsersNonMembresByPseudo(string $pseudo, ListeTaches $listeTaches) : array {

    	$membres = self::getMembres($listeTaches);
    	$utilisateurs = self::getUsersByPseudo($pseudo);

    	$membres_email = array();
    	foreach ($membres as $membre) {
    		array_push($membres_email, $membre->email);
	    }

    	$res = array();
    	foreach ($utilisateurs as $utilisateur) {
    		if (!in_array($utilisateur->email, $membres_email)) {
    			array_push($res, $utilisateur);
		    }
	    }

    	return $res;
	}



    //---------------------------- FIN ListeTaches---------------------------------

    //---------------------------- Taches -------------------------------------
    /**
     * Indique que la tache est complétée
     * @param Tache $task
     * @return bool
     */
    public static function setDone(Tache $task) {

        if (!isset($task)) {
            return false;
        }

        if ($task->estFinie()) {
            return false;
        }

        $task->setFait(true);
        return self::$dao_tache->update($task);
    }

    /**
     * Indique que la tâche n'est pas complétée
     * @param Tache $task
     * @return bool
     */
    public static function setNotDone(Tache $task) {

        if (!isset($task)) {
            return false;
        }

        if (!$task->estFinie()) {
            return false;
        }

        $task->setFait(false);
        return self::$dao_tache->update($task);
    }


    /**
     * Supprimer une tache
     * La BDD s'occupe de la suppression des choses liées
     * @param int $idTache
     * @return bool
     */
    public static function supprimerTache(int $idTache) : bool {
        if (!isset($idTache)) {
            return false;
        }

        $tache = self::getTaskById($idTache);
        return self::$dao_tache->supprimerDeBDD($tache);
    }

    /**
     * Ajouter un Utilisateur à une Tache
     * retourne false en cas d'échec
     * @param Tache $tache
     * @param Utilisateur $utilisateur
     * @return bool
     */
    public static function ajouterResponsable(Tache $tache, Utilisateur $utilisateur){
        //verifier si un utilisateur est déjà defini pour la tache

        if (!isset($tache) || !isset($utilisateur)) {
            return false;
        }

        $liste = Systeme::getListeTachesByID($tache->idListe);
        $membres = Systeme::getMembres($liste);

        if (!in_array($utilisateur, $membres)) {
            return false;
        }

        $tache->ajouterResponsable($utilisateur);
        $condition = "idTache == $tache->id";
        return self::$dao_tache->updateBDD($tache,$condition);
    }

    /**
     * Retirer un Utilisateur à une Tache
     * retourne false en cas d'échec
     * @param Tache $tache
     * @return bool
     */
    public static function retirerResponsable(Tache $tache){
        //verifier si un utilisateur est déjà defini pour la tache

        if (!isset($tache)) {
            return false;
        }

        $tache->supprimerResponsable();
        $condition = "idTache == $tache->id";
        return self::$dao_tache->updateBDD($tache,$condition);
    }


    /**
     * Retourne la tache associée à l'ID en paramètre
     * @param int $idTache
     * @return Tache
     */
    public static function getTaskById(int $idTache) : Tache {
        if(!isset($idTache)) return null;

        $resSQL = self::$dao_tache->getByRequete("idTache = $idTache");

        $req = $resSQL[0];

        $tache = new Tache($req['nom'], $req['idListe']);
        $tache->finie = $req['statut'];
        $tache->id = $req['idTache'];
        if(isset($req['idResponsable'])){
            $tache->responsable = $req['idResponsable'];
        }

        return $tache;
    }


    //---------------------------- FIN Taches ---------------------------------



    //---------------------------- Invitations ------------------------------------

    /**
     * Supprime une invitation
     * @param InvitationListeTache $invitation
     * @return bool
     */
    public static function refuserInvitation(InvitationListeTache $invitation){
        //TODO: est-ce qu'on doit notifier celui qui a envoyé l'invitation que cette invitation a été refusée ?
        // Réponse de Ugo: OUI!
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

        $invitation = new InvitationListeTache("Je t‘invite à rejoindre la liste " . $liste->nom, $emetteur->id, $destinataire->id, $liste->id);
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

    //---------------------------- FIN Invitations ---------------------------------

    //---------------------------- Notifications ---------------------------------

    /**
     * Ajoute une NotificationTache dans la BDD
     * @param string $message
     * @param int $idListe
     * @param int $idTache
     * @param int $idDestinataire
     * @return bool
     */
    public static function createNotificationTache(string $message, int $idListe, int $idTache, int $idDestinataire) : bool {
        if (!isset($message) || !isset($idListe) || ! isset($idTache) || !isset($idDestinataire)) {
            return false;
        }

        $notifTache = new NotificationTache(SQLite3::escapeString($message), false, $idListe, $idTache, $idDestinataire);

        return self::$dao_notif->ajouterDansBDD($notifTache);
    }

    /**
     * Ajoute une NotificationListeTache dans la BDD
     * @param string $message
     * @param int $idListe
     * @param int $idDestinataire
     * @return bool
     */
    public static function createNotificationListeTaches(string $message, int $idListe, int $idDestinataire) : bool {
        if (!isset($message) || !isset($idListe)  || !isset($idDestinataire)) {
            return false;
        }

        $notifListeTache = new NotificationListeTaches(SQLite3::escapeString($message), false, $idListe, $idDestinataire);

        return self::$dao_notif->ajouterDansBDD($notifListeTache);

    }

    /**
     * Supprime une notification
     * @param Notification $notif
     * @return bool
     */
    public static function supprimerNotification(Notification $notif) : bool {
        if (!isset($notif)) {
            return false;
        }

        return self::$dao_notif->supprimerDeBDD($notif);
    }

    /**
     * Supprime une Notification
     * @param int $idNotification
     * @return bool
     */
    public static function supprimerNotificationByID(int $idNotification) : bool {
        if (!isset($idNotification)) {
            return null;
        }

        return self::$dao_notif->supprimerDeBDDByID($idNotification);
    }

    /**
     * Retourne un tableau contenant des Obj Not
     * @param int $idUtilisateur
     * @return array
     */
    public static function getNotificationsTache(int $idUtilisateur) : array {
        if (!isset($idUtilisateur)) {
            return null;
        }
        return self::$dao_notif->getNotificationsTache($idUtilisateur);
    }

    /**
     * Récupère de la BDD toutes les Notifications de type ListeTache liées à un Utilisateur
     * @param int $idUtilisateur
     * @return array
     */
    public static function getNotificationsListe(int $idUtilisateur) : array {
        if (!isset($idUtilisateur)) {
            return null;
        }

        return self::$dao_notif->getNotificationsListeTache($idUtilisateur);
    }


    /**
     * Retourne le nombre de notifications
     * @param $idUtilisateur
     * @return int|null
     */
    public static function getNbNotifications(int $idUtilisateur) : int{
        if (!isset($idUtilisateur)) {
            return null;
        }
        $nbNotifs = 0;

        $nbNotifs += count(self::getNotificationsListe($idUtilisateur));
        $nbNotifs += count(self::getNotificationsTache($idUtilisateur));

        return $nbNotifs;
    }



    /**
     * Crée une NotificationTache pour tous les membres d'une ListeTaches
     * @param String $msg
     * @param int $idListe
     * @param int $idTask
     * @return bool
     */
    public static function notifierTacheTousMembresListe(String $msg, int $idListe, int $idTask) {
        $res = true;
        $liste = self::getListeTachesByID($idListe);
        $membres = self::getMembres($liste);
        foreach ($membres as $utilisateur){
            $idutil=$utilisateur->id;
            $res = $res && self::createNotificationTache($msg,$idListe,$idTask,$idutil);
        }

        return $res;
    }

    //---------------------------- FIN Notifications ---------------------------------


}