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
$new_prop = Systeme::_POST('new_prop');

if ($new_prop == false) {
    error_log("Aucun ID d'user");
    header("location: ./");
    exit;
}

$new_prop = intval($new_prop);

if ($new_prop == null) {
    error_log("Format de l'ID d'user incorrect");
    header("location: ./");
    exit;
}

$membre = Systeme::getUserByID($new_prop);

if ($membre == null) {
    error_log("Aucun user d'ID $new_prop");
    header("location: ./");
    exit;
}

if ($membre->id == $user->id) {
	error_log("Impossible de se céder soi-meme la propriété d'une liste");
	header("location: ./");
	exit;
}

if ($liste->proprietaire != $user->id) {
    error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $lid");
    header("location: ./");
    exit;
}

$invitations = Systeme::getInvitations($user);

foreach ($invitations as $invitation) {
	if ($invitation->liste == $liste->id && $invitation->id < 0) {
		Systeme::refuserInvitation($invitation);
	}
}

Systeme::demandeTransfertPropriete($liste, $current_user, $user);

header("location: ./");
exit;
