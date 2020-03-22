<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()){
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

Systeme::Init();

$logged_user = Systeme::getUserByID($uid);

if ($logged_user == null){
	header("location: ../Login");
	exit;
}

$pseudo = Systeme::_POST('pseudo');

$prenom = Systeme::_POST('prenom');

$nom = Systeme::_POST('nom');

$email = Systeme::_POST('email');

$conf_password = Systeme::_POST('conf-password');

if ($conf_password == false) {
    //die("veuillez entrer votre mot de passe");
    header("location: edit.php?erreur=2");
    exit;
}

if ($conf_password != $logged_user->mdp) {
	header("location: edit.php?erreur=3");
    exit;
}


if ($pseudo != "" && $pseudo != $logged_user->pseudo) {
	$logged_user->pseudo = SQLite3::escapeString($pseudo);
}

if ($prenom != "" && $prenom != $logged_user->prenom) {
	$logged_user->prenom = SQLite3::escapeString($prenom);
}

if ($nom != "" && $nom != $logged_user->nom) {
	$logged_user->nom = SQLite3::escapeString($nom);
}


if ($email != "" && $email != $logged_user->email) {

    $val = Systeme::getUserByEmail(SQLite3::escapeString($email)); //Test si l'email est déjà utilisée par un autre compte
    if ($val == null)
        $logged_user->email = SQLite3::escapeString($email);
    else {
        //die("email deja existant");
        header("location: edit.php?erreur=1");
        exit;
    }

}

if (Systeme::updateUser($logged_user)) {
	header("location: .");
	$_SESSION["username"] = $logged_user->pseudo;
	exit;
} else {
	header("location: edit.php?erreur=3");
	exit;
}