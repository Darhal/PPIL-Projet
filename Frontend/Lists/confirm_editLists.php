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

if (!isset($_POST['lid'])){
	error_log("Aucun ID de liste");
	header("location: index.php");
	exit;
}

$lid = intval(SQLite3::escapeString($_POST['lid']));

if (!is_int($lid)) {
    error_log("L'ID de liste n'est pas valide");
	//header("location: index.php");
	echo 1;
	exit;
}

$list = Systeme::getListeTachesByID($lid);

if ($list == null) {
    error_log("Liste d'ID " . $lid . " inexistante");
	//header("location: index.php");
	echo 2;
	exit;
}

if ($list->proprietaire != $uid) {
	error_log("Utilisateur non propriétaire de la liste");
	header("location: ./");
}

if (!isset($_POST['debut'])){
	error_log("Aucune date de debut de liste");
	//header("location: index.php");
	echo 3;
	exit;
}

$debut = SQLITE3::escapeString(($_POST['debut']));
$debut = trim($debut);

if (!isset($_POST['fin'])){
	error_log("Aucune date de fin de liste");
	//header("location: index.php");
	echo 4;
	exit;
}

$fin = SQLITE3::escapeString(($_POST['fin']));
$fin = trim($fin);

if ($fin === "") {
	$fin = null;
}


if (!isset($_POST['nom'])){
	error_log("Aucun nom de liste");
	//header("location: index.php");
	echo 5;
	exit;
}

$nom = SQLITE3::escapeString(($_POST['nom']));
$nom = trim($nom);

$sdate = strtotime($debut);
if ($sdate == false) {
	error_log("Date de début au format invalide");
	//header("location: index.php");
	echo 6;
	exit;
}

if ($fin != null) {
	$edate = strtotime($fin);
	if ($edate == false) {
		error_log("Date de fin au format invalide");
		//header("location: index.php");
		echo 7;
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

// TODO: - Vérifier le mot de passe de l'utilisateur lors de la modification