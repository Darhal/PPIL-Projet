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
$list = Systeme::getListeTachesByID($task->idListe) ;
if($task == null) {
	// TODO: - Afficher une erreur
	die("Aucune tache d'ID " . $tid);
}

if ($task->aUnResponsable()) {
	die("Un responsable est déjà assigné à cette tâche");
}

if(!Systeme::notifierTacheTousMembresListe("$user->pseudo vient de se porter volontaire pour la tache $task->nom de $list->nom", $list->id, $task->id)){
    error_log("Une erreur est survenue lors de la notification de volontaire de liste $list->id avec tache $task->id");
}

Systeme::ajouterResponsable($task, $user);

header("location: ../Lists/View/index.php?id=$task->idListe");