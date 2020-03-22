<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

Systeme::Init();

$logged_user = Systeme::getUserByID($uid);

if ($logged_user == null){
	header("location: ../Login/logout.php");
}

$old_password = Systeme::_POST('old-password');

if ($old_password == false) {
	header("location: ./change_password.php?erreur=1");
}

$new_password = Systeme::_POST('new-password');

if($new_password == false) {
	header("location: ./change_password.php?erreur=1");
}

$conf_password = Systeme::_POST('conf-password');

if($conf_password == false) {
	header("location: ./change_password.php?erreur=1");
}

if($logged_user->mdp != $old_password){
    header("location: ./change_password.php?erreur=2");
    exit;
}

if ($new_password == $conf_password) {
	if (Systeme::changePassword($logged_user, $old_password, $new_password)) {
		header("location: ./index.php");
	} else {
		header("location: ./change_password.php?erreur=3");
		exit;
	}
} else {
	header("location: ./change_password.php?erreur=4");
}