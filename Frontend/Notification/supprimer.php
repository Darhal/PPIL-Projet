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

	header( "location: notification.php");
}

$invID = intval($_GET['id']);

$notifications = Systeme::getNotifications($utilisateur);

foreach ($notifications as $notification) {
	if ($notification->id == $invID) {
		Systeme::supprimerNotification($notification);
	}
}

header( "location: notification.php");