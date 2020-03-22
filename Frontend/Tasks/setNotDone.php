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

if (!isset($_POST['tid'])) {
	// TODO: - Afficher une erreur
	die("ID de tâche non défini");
}

$tid = $_POST['tid'];

if (intval($tid) == null) {
	// TODO: - Afficher une erreur
	die("Format de l'ID invalide");
}

$tid = intval($tid);

$task = Systeme::getTaskById($tid);
$liste = Systeme::getListeTachesByID($task->idListe) ;
if($task == null) {
	// TODO: - Afficher une erreur
	die("Aucune tache d'ID " . $tid);
}

$list = Systeme::getListeTachesByID($task->idListe);

if (!$task->aUnResponsable()) {
	if ($user->id != $list->proprietaire) {
		error_log("La tâche $task->id n'a pas de responsable");
		header("location: ../Lists/View/index.php?id=$task->idListe");
		exit;
	}
} else {
	if ($task->responsable != $user->id) {
		error_log("L'utilisateur $user->pseudo n'est pas responsable de la tâche $task->id");
		header("location: ../Lists/View/index.php?id=$task->idListe");
		exit;
	}
}

if (!$task->estFinie()) {
	die("La tâche n'est pas marquée comme finie");
}

Systeme::setNotDone($task);

if(!Systeme::notifierTacheTousMembresListe("La tache $task->nom de $liste->nom a été marquée comme non finie", $task->idListe, $task->id)){
    error_log("Une erreur est survenue lors de la non completion de la liste $liste->id avec tache $task->id");
}
header("location: ../Lists/View/index.php?id=$task->idListe");