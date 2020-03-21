<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if(!Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

$user = Systeme::getUserByID($uid);

if ($user == null) {
	error_log("Aucun utilisateur d'ID $uid");
	header("location: ../Login/logout.php");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Type de requête invalide");
	header("location: ./");
	exit;
}

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("Aucun ID de liste");
	header("location: ./");
	exit;
}

$lid = trim($lid);
$lid = intval($lid);

if ($lid == null) {
	error_log("Format de l'ID de liste incorrect");
	header("location: ./");
	exit;
}

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	error_log("Aucune liste d'ID $lid");
	header("location: ./");
	exit;
}

if ($liste->proprietaire != $user->id) {
	error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $lid");
	header("location: ./");
	exit;
}

if (!Systeme::supprimerListeByID($liste->id)) {
    error_log("Une erreur est survenue lors de la suppression de la liste $lid par $user->pseudo");
}


header("location: ./");
exit;
