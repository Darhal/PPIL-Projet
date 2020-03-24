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
	header("location: ../Frontend/Lists/creer.php");
	exit;
}

$uid = $_SESSION["id"];

$nom = Systeme::_POST('listName');

if ($nom == false) {
	error_log("Aucun nom de liste");
	header("location: ../Lists/creer.php");
	exit;
}

$nom = trim($nom);

if (empty($nom)) {
	error_log("Nom de liste vide");
	header("location: ../Lists/creer.php");
}

$dateDebut = Systeme::_POST('startingDate');

if (isset($_POST['startingDate'])) {
	error_log("Aucune date de début");
	header("location: ../Lists/creer.php");
}

$dateDebut = trim($dateDebut);

$dateFin = Systeme::_POST('endingDate');

if ($dateFin == false) {
	error_log("Aucune date de fin");
	header("location: ../Lists/creer.php");
}

$dateFin = trim($dateFin);
if (empty($dateFin)) {
	$dateFin = null;
}

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

    if(!Systeme::createNotificationListeTaches("Vous venez de creer une nouvelle liste $nom", -1, $uid)){
        error_log("Une erreur est survenue lors de la creation de la liste $nom");
    }

	header("location: ./");
} else {
	error_log("erreur");
	// TODO: - Erreur
	header("location: ./");
	exit;
}

