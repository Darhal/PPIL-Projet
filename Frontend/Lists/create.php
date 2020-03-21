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
	header("location: ../Frontend/Login");
	exit;
}

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Type de requête invalide");
	header("location: ../Frontend/Lists/creer.php");
	exit;
}

$uid = $_SESSION["id"];

if (isset($_POST['listName'])) {
	$nom = SQLite3::escapeString($_POST['listName']);
	$nom = trim($nom);
} else {
	error_log("Aucun nom de liste");
	header("location: ../Frontend/Lists/creer.php");
	exit;
}

if (empty($nom)) {
	error_log("Nom de liste vide");
	header("location: ../Frontend/Lists/creer.php");
}

if (isset($_POST['startingDate'])) {
	$dateDebut = SQLite3::escapeString($_POST['startingDate']);
	$dateDebut = trim($dateDebut);
	echo strtotime("dfg");
} else {
	error_log("Aucune date de début");
	header("location: ../Frontend/Lists/creer.php");
}

if (isset($_POST['endingDate'])) {
	$dateFin = SQLite3::escapeString($_POST['endingDate']);
	$dateFin = trim($dateFin);

	if ($dateFin === "") {
		$dateFin = null;
	}
} else {
	error_log("Aucune date de fin");
	header("location: ../Frontend/Lists/creer.php");
}

var_dump($_POST);

// Requête SQL

$sdate = strtotime($dateDebut);
if ($sdate == false) {
	error_log("Date de début au format invalide");
	header("location: ../Frontend/Lists/creer.php");
}

if ($dateFin != null) {
	$edate = strtotime($dateFin);
	if ($edate == false) {
		error_log("Date de fin au format invalide");
		header("location: ../Frontend/Lists/creer.php");
	}
} else {
	$edate = null;
}

if (Systeme::createList($nom, $sdate, $edate, $uid)) {
	header("location: /Frontend/Lists");
} else {
	// TODO: - Erreur
	error_log("erreur");
	exit;
}

