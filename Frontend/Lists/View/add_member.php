<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if (!Systeme::estConnecte()) {
	header("location: ../");
}

$current_userID = $_SESSION['id'];
$current_user = Systeme::getUserByID($current_userID);

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Type de requête invalide");
	header("location: ../");
}

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("ID de liste non défini");
	header("location: ../");
}

$lid = trim($lid);
$lid = intval($lid);

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	error_log("Aucune liste d'ID $lid");
	header("location: ../");
}

if ($liste->proprietaire != $current_user->id) {
	error_log("L'utilisateur $current_user->pseudo n'est pas propriétaire de la liste $lid");
	header("location: ../");
}

$umail = Systeme::_POST('user');

if ($umail == false) {
	error_log("Utilisateur à ajouter non défini");
	header("location: ../");
}

$umail = trim($umail);

$user = Systeme::getUserByEmail($umail);

$invitations = Systeme::getInvitations($user);

foreach ($invitations as $invitation) {
	if ($invitation->liste == $liste->id) {
		Systeme::refuserInvitation($invitation);
	}
}

Systeme::inviterUtilisateur($liste, $current_user, $user);

header("location: ../index.php?id=$liste->id");