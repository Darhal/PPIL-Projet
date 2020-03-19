<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(Systeme::estConnecte()){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

include_once "Backend/Utilisateur/Utilisateur.php";

Systeme::Init();

$logged_user = Systeme::getUserByID($uid);

if ($logged_user == null){
	die("ERROR: Unable to find user by email");
}

if (!isset($_POST['pseudo'])) {
	die("pseudo non défini");
}

$pseudo = $_POST['pseudo'];

if (!isset($_POST['prenom'])) {
	die("prenom non défini");
}

$prenom = $_POST['prenom'];

if (!isset($_POST['nom'])) {
	die("nom non défini");
}

$nom = $_POST['nom'];

if (!isset($_POST['email'])) {
	die("email non défini");
}

$email = $_POST['email'];



if (!isset($_POST['conf-password'])) {
    //die("veuillez entrer votre mot de passe");
    header("location: edit.php?erreur=2");
    exit;
}

$password = $_POST['conf-password'];


if ($password != $logged_user->mdp) {
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
	header("location: /Frontend/Profil");
	$_SESSION["username"] = $logged_user->pseudo;
	exit;
} else {
	header("location: edit.php?erreur=3");
	exit;
}