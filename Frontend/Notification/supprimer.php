<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";
include_once "Backend/Notifications/Notification.php";

Systeme::start_session();

if (!Systeme::estConnecte()) {
    header("location: ../Login");
}

Systeme::Init();
$uid = $_SESSION['id'];
include_once "Backend/Utilisateur/Utilisateur.php";

$utilisateur = Systeme::getUserByID($uid);
$notifID = Systeme::_POST('lid');

if ($notifID == false) {
    error_log("ID de notification non défini");
    header("location: ./notification.php");
    exit;
}

$notifID = intval($notifID);

if (!is_int($notifID)) {
    die("L'ID de la notification n'est pas valide $notifID");
}

if(Systeme::supprimerNotificationByID($notifID)){
    header( "location: notification.php");
}else{
    error_log("Erreur supprission notification");
    echo "Erreur" ;
}


