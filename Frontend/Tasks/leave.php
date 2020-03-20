<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

Systeme::Init();

$user = Systeme::getUserByID($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// TODO: - Afficher une erreur
	header( "location: ../Lists/View/index.php?id=$task->idListe" );
}

$tid = Systeme::_POST('tid');

if ($tid == false) {
	error_log("ID de tâche non défini");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=1" );
	exit;
}

$tid = intval($tid);

if ($tid == null) {
	error_log("Format de l'ID invalide");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=2" );
	exit;
}


$task = Systeme::getTaskById($tid);

if($task == null) {
	error_log("Aucune tache d'ID $tid");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=3" );
	exit;
}

if (!$task->aUnResponsable()) {
	error_log("Aucun responsable n'est déjà assigné à cette tâche");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=4" );
	exit;
}

$liste = Systeme::getListeTachesByID($task->idListe);

if ($liste == null) {
	error_log("Tache $task->id associée à une liste $task->idListe inexistante");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=5" );
	exit;
}

// Seuls l'assigné à la tâche et le propriétaire de la liste peuvent supprimer le responsable de la tâche
if ($liste->proprietaire != $user->id and $task->responsable != $user->id) {
	error_log("Utilisateur $user->pseudo n'a pas le droit de retirer le responsable de la tâche $task->id");
	header( "location: ../Lists/View/index.php?id=$task->idListe?erreur=6" );
	exit;
}

Systeme::retirerResponsable($task);

header("location: ../Lists/View/index.php?id=$task->idListe");