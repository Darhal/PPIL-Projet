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
	header("location: index.php");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("Aucun ID de liste");
	header("location: index.php");
	exit;
}

$lid = intval($lid);

if (!is_int($lid)) {
    error_log("L'ID de liste n'est pas valide");
    // TODO: - Retourner une erreur
	header("location: index.php");
	exit;
}

$list = Systeme::getListeTachesByID($lid);

if ($list == null) {
    error_log("Liste d'ID " . $lid . " inexistante");
	header("location: index.php");
	exit;
}

if ($list->proprietaire != $uid) {
	error_log("Utilisateur non propriétaire de la liste");
	header("location: ./");
}

$debut = Systeme::_POST('debut');

if ($debut == false){
	error_log("Aucune date de debut de liste");
	header("location: index.php");
	exit;
}

$debut = trim($debut);

$fin = Systeme::_POST('fin');

if ($fin == false){
	error_log("Aucune date de fin de liste");
	header("location: index.php");
	exit;
}

$fin = trim($fin);

if (empty($fin)) {
	$fin = null;
}

$nom = Systeme::_POST('nom');
if ($nom == false && !empty($nom)){
	error_log("Aucun nom de liste");
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