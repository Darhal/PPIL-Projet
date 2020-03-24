<?php

set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$user = Systeme::getUserByID($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Invalid request");
	header( "location: ../Lists/creer.php?erreur=0" );
}

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("ID de liste non défini");
	header( "location: ../Lists/creer.php?erreur=1" );
}

$lid = intval($lid);

if (!is_int($lid)) {
	error_log("L'ID de liste n'est pas valide");
	header( "location: ../Lists/creer.php?erreur=2" );
}

$liste = Systeme::getListeTachesByID($lid);
include_once "Backend/Utilisateur/Utilisateur.php";

if ($liste == null) {
	error_log("Liste d'ID " . $lid . " inexistante");
	header( "location: ../Lists/creer.php?erreur=3" );
}

if ($liste->proprietaire != $user->id) {
	error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $liste->id");
	header("location: ../Lists/View/index.php?id=$liste->id");
	exit;
}

$tname = Systeme::_POST('tname');

if ($tname == false) {
	error_log("Nom de tâche non défini");
	header("location: ../Lists/creer.php?erreur=4");

}

if (!is_string($tname)) {
	error_log("Nom de tâche invalide");
	header("location: ../Lists/creer.php?erreur=5");
}

include_once "Backend/Taches/Tache.php";

$res = Systeme::createTask($tname, $liste);

if(!Systeme::notifierListeTousMembresListe("La tache $tname vient d'etre ajoutée à $liste->nom", $liste->id)){
    error_log("Une erreur est survenue lors de la notification des membres de la liste, mais la tâche à bien été créée");
	header("location: ../Lists/creer.php?erreur=6");
}
if ($res == true) {
	header("location: ../Lists/View/index.php?id=" . $liste->id);
} else {
	error_log("Une erreur est survenue lors de la creation de la tache $tname");
	header("location: ../Lists/creer.php?erreur=6");
}