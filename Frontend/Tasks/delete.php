<?php

set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";
include_once "Backend/Taches/Tache.php";

Systeme::start_session();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	//header("location: ../Login");
	exit;
}

Systeme::Init();
$user = Systeme::getUserByID($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
	// TODO: - Afficher une erreur
	header( "location: ../Lists" );
}

if (!isset($_GET['id'])) {
	// TODO: - Afficher une erreur
	die("ID de tâche non défini");
}


//id de la liste
$id = intval(SQLite3::escapeString($_GET['id']));

if (!is_int($id)) {
	// TODO: - Afficher une erreur
	die("L'ID de la tache n'est pas valide");
}


$task = Systeme::getTaskById($id);

if ($task == null) {
	// TODO: - Afficher une erreur
	die("Aucune tâche d'ID " . $id);
}

if ($task->aUnResponsable()) {
	$task->supprimerResponsable();
	Systeme::retirerResponsable($task);
}

$lid = $task->idListe;

$list = Systeme::getListeTachesByID($lid);
if ($list == null) {
	// TODO: - Afficher une erreur
	die("Aucune liste existante associée à la tâche");
}

if ($list->proprietaire == $user->id) {
	// L'utilisateur est le propriétaire de la liste, il peut donc supprimer
	if (Systeme::supprimerTache($task->id)) {
	    //envoie notif pour avertir de la suppression

        //envoie une notification

        if(!Systeme::notifierTacheTousMembresListe("tache supprime", $lid, $task->id)){
            error_log("Une erreur est survenue lors de la notification de la suppression de liste $lid avec tache $task->id");

        }
        //redirection
		header("location: ../Lists/View/index.php?id=" . $lid);
	}
}

// TODO: - Afficher une erreur
echo "failure";