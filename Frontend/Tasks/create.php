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

$user = Systeme::getUserByID($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// TODO: - Afficher une erreur
	header( "location: ../Lists" );
}

if (!isset($_POST['lid'])) {
	// TODO: - Afficher une erreur
	die("ID de liste non défini");
}

$lid = intval(SQLite3::escapeString($_POST['lid']));

if (!is_int($lid)) {
	// TODO: - Afficher une erreur
	die("L'ID de liste n'est pas valide");
}

Systeme::Init();
$liste = Systeme::getListeTachesByID($lid);
include_once "Backend/Utilisateur/Utilisateur.php";

$uid = $_SESSION["id"];
$user = Systeme::getUserByID($uid) ;
if ($liste == null) {
	// TODO: - Afficher une erreur
	die("Liste d'ID " . $lid . " inexistante");
}

if ($liste->proprietaire != $user->id) {
	error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $liste->id");
	header("location: ../Lists/View/index.php?id=$liste->id");
	exit;
}

if (!isset($_POST['tname'])) {
	// TODO: - Afficher une erreur
	die("Nom de tâche non défini");
}

$tname = SQLite3::escapeString(strval($_POST['tname']));

if (trim($tname) == "") {
	header("location: ../Lists/View/index.php?id=" . $liste->id);
}

if (!is_string($tname)) {
	// TODO: - Afficher une erreur
	die("Le nom de tâche n'est pas valide");
}

include_once "Backend/Taches/Tache.php";

$res = Systeme::createTask($tname, $liste);



if(!Systeme::notifierListeTousMembresListe("La tache $tname vient d'etre ajoutée à $liste->nom", $liste->id)){
    error_log("Une erreur est survenue lors de la creation de la tache $tname");
}
if ($res == true) {
	header("location: ../Lists/View/index.php?id=" . $liste->id);
} else {
	// TODO: - Afficher une erreur
	echo "failure";
}