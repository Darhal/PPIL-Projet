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

if (!isset($_GET['lid'])) {
	header( "location: notification.php");
}

$notifID = intval($_GET['lid']);

$notifTache = Systeme::getNotificationsTache($utilisateur->id) ;
$notifList = Systeme::getNotificationsListe($utilisateur->id);

$notifications = array_merge($notifTache, $notifList); //fusion des notifs

foreach ($notifications as $notification) {
	echo "$notification->id | $notifID";
	if ($notification->id == $notifID) {
		if(Systeme::supprimerNotification($notification)){
            // header( "location: notification.php");
        }else{
		    echo "erreur" ;
        }
	}
}

