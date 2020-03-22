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

//L'utilisateur connecté
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

//récupération de la liste
$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("Aucune ID de liste");
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

//récupération du membre à supprimer
$udeleteid = Systeme::_POST('udeleteid');

if ($udeleteid == false) {
    error_log("Aucun ID d'user");
    header("location: ./");
    exit;
}

$udeleteid = trim($udeleteid);
$udeleteid = intval($udeleteid);

if ($udeleteid == null) {
    error_log("Format de l'ID d'user incorrect");
    header("location: ./");
    exit;
}

$membre = Systeme::getUserByID($udeleteid);

if ($membre == null) {
    error_log("Aucun user d'ID $udeleteid");
    header("location: ./");
    exit;
}

if ($liste->proprietaire != $user->id) {
    error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $lid");
    header("location: ./");
    exit;
}

if ($membre->id == $liste->proprietaire) {
    error_log("L'utilisateur $user->pseudo est propriétaire de la liste d'ID $lid et ne peut pas la supprimer");
    header("location: ./View/index.php?id=".$liste->id);
    exit;
}

if (!Systeme::quitterListe($membre, $liste)) {
    error_log("Une erreur est survenue lors de la suppression de l'utilisateur $udeleteid");
}


if(!Systeme::notifierListeTousMembresListe("$membre->pseudo a été supprimé.e de la liste $liste->nom", $liste->id)){
    error_log("Une erreur est survenue lors de la suppression de $membre->pseudo de la liste $liste->nom");
}

header("location: ./");
exit;
