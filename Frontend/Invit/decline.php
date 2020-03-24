<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if (!Systeme::estConnecte()) {
    // TODO: - Afficher une erreur
    header("location: ../Login");
}

Systeme::Init();

$uid = $_SESSION['id'];
$utilisateur = Systeme::getUserByID($uid);

$invID = Systeme::_GET('id');

if ($invID == false) {
	error_log("ID d'invitation non défini");
	header( "location: invitation.php");
}

$invID = intval($invID);

if ($invID == null) {
	error_log("ID d'invitation au format invalide");
	header( "location: invitation.php");
}

$invitations = Systeme::getInvitations($utilisateur);

foreach ($invitations as $invitation) {
    if ($invitation->id == $invID) {
    	Systeme::refuserInvitation($invitation);
    }
}

header( "location: invitation.php");