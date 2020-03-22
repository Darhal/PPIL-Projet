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

if (!$task->aUnResponsable()) {
	die("Aucun responsable n'est assigné pour la tâche $task->id");
}

if (!$task->estFinie()) {
	die("La tâche n'est pas marquée comme finie");
}

Systeme::setNotDone($task);

if(!Systeme::notifierTacheTousMembresListe("La tache $task->nom de $liste->nom a été marquée comme non finie", $task->idListe, $task->id)){
    error_log("Une erreur est survenue lors de la non completion de la liste $liste->id avec tache $task->id");
}
header("location: ../Lists/View/index.php?id=$task->idListe");