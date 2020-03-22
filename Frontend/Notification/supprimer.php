<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";
include_once "Backend/Notifications/Notification.php";

Systeme::start_session();

if (!Systeme::estConnecte()) {
	// TODO: - Afficher une erreur
	header("location: ../Login");
}
Systeme::Init();


$uid = $_SESSION['id'];
include_once "Backend/Utilisateur/Utilisateur.php";


$utilisateur = Systeme::getUserByID($uid);

$notifID = intval(SQLite3::escapeString($_GET['lid']));

if (!is_int($id)) {
    // TODO: - Afficher une erreur
    die("L'ID de la notification n'est pas valide $notifID");
}
//$notifID = intval($_GET['lid']);



if(Systeme::supprimerNotificationByID($notifID)){
    header( "location: notification.php");
}else{
    error_log("erreur supprission notification");

    //TODO redirection
    echo "erreur" ;
}

/*
foreach ($notifications as $notification) {
	echo "$notification->id | $notifID";
	if ($notification->id == $notifID) {

	}
}*/

