<?php
// Affichage des erreurs
set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

// Démarrage de la session
Systeme::start_session();

Systeme::Init();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Type de requête invalide");
	header("location: ../Lists");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

$tid = Systeme::_POST('tid');

if ($tid == false) {
	error_log("Aucun ID de tâche");
	header("location: ../Lists");
	exit;
}

$tid = intval($tid);

if (!is_int($tid)) {
    error_log("L'ID de tâche n'est pas valide");
    // TODO: - Retourner une erreur
	header("location: ../Lists");
	exit;
}

$task = Systeme::getTaskById($tid);

if ($task == null) {
	error_log("Aucune tâche d'ID $tid");
	header("location: ../Lists");
	exit;
}

$list = Systeme::getListeTachesByID($task->idListe);

if ($list == null) {
    error_log("Liste d'ID " . $lid . " inexistante");
	header("location: ../Lists");
	exit;
}

if ($list->proprietaire != $uid) {
	error_log("Utilisateur non propriétaire de la liste");
	header("location: ../Lists/View/index.php?id=$list->id");
}

$nom = Systeme::_POST('nom');
if ($nom == false && !empty($nom)){
	error_log("Aucun nom de tâche");
	header("location: index.php");
	exit;
}

$nom = trim($nom);

$sdate = strtotime($debut);
if ($sdate == false) {
	error_log("Date de début au format invalide");
	header("location: index.php");
	exit;
}

if ($fin != null) {
	$edate = strtotime($fin);
	if ($edate == false) {
		error_log("Date de fin au format invalide");
		header("location: index.php");
		exit;
	}
} else {
	$edate = null;
}


if ($sdate != $list->dateDebut) {
    $list->dateDebut = $sdate;
}

if (!empty($nom) && $nom != $list->nom) {
    $list->nom = trim($nom);
}

if ($list->dateFin == "NULL") {
	if ($fin != null) {
		$list->dateFin = $edate;
	}
} else {
	$list->dateFin = $edate;
}
if (Systeme::updateList($list)) {
    header("location: ./");
    exit;
} else {
    header("location: editLists.php?erreur=1");
    exit;
}