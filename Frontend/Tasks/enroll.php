<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: ../Lists");
	exit;
}

Systeme::Init();

$user = Systeme::getUserByID($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// TODO: - Afficher une erreur
	header( "location: ../Lists" );
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

if($task == null) {
	// TODO: - Afficher une erreur
	die("Aucune tache d'ID " . $tid);
}

if ($task->aUnResponsable()) {
	die("Un responsable est déjà assigné à cette tâche");
}

Systeme::ajouterResponsable($task, $user);

header("location: ../Lists");