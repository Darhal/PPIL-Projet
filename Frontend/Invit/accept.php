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


$invitations = Systeme::getInvitations($utilisateur);   //Les invitations de l'utilisateur connecté

foreach ($invitations as $invitation) {
    if ($invitation->id == $invID) {
        $liste = Systeme::getListeTachesByID($invitation->liste);   //La liste correspondant à l'invitation


        if($invID < 0) {         //Demande de transfère de droit
            if (!Systeme::notifierListeTousMembresListe("$utilisateur->pseudo est maintenant le propriétaire de la liste $liste->nom", $liste->id)) {
                error_log("Une erreur est survenue lors de l'acceptation du transfere de propriété de la liste $liste->id");
            }
            Systeme::accepterDemandeTransfert($invitation);
        }
        else {                  //Invitation à une liste
            if (!Systeme::notifierListeTousMembresListe("$utilisateur->pseudo vient de rejoindre la liste $liste->nom", $liste->id)) {
                error_log("Une erreur est survenue lors de l'acceptation à l'invitation de la liste $liste->id");
            }
            Systeme::accepterInvitation($invitation);
        }
    }
}



header( "location: invitation.php");