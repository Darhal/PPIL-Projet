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


if (!isset($_GET['id'])) {
	// TODO: - Afficher une erreur
	header( "location: invitation.php");
}

$invID = intval($_GET['id']);

$invitations = Systeme::getInvitations($utilisateur);

foreach ($invitations as $invitation) {
	if ($invitation->id == $invID) {
	    $liste = Systeme::getListeTachesByID($invitation->liste);
        if(!Systeme::notifierListeTousMembresListe("$utilisateur->pseudo vient de rejoindre la liste $liste->nom", $liste->id)){
            error_log("Une erreur est survenue lors de la acceptation de l invitation de la liste $liste->id");
        }
		Systeme::accepterInvitation($invitation);
	}
}

header( "location: invitation.php");