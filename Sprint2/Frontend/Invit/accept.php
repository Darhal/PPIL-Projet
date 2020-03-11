<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if (!Systeme::estConnecte()) {
	// TODO: - Afficher une erreur
	header("location: /Frontend/Login");
}

Systeme::Init();

$uid = $_SESSION['id'];
$utilisateur = Systeme::getUserByID($uid);

if (!isset($_GET['id'])) {
	// TODO: - Afficher une erreur
	header( "location: invitation.php");
}

$invID = intval($_GET['id']);

$invitations = Systeme::getInvitations($utilisateur);

foreach ($invitations as $invitation) {
	if ($invitation->id == $invID) {
		Systeme::accepterInvitation($invitation);
	}
}

header( "location: invitation.php");