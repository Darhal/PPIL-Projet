<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

$pseudo = Systeme::_POST('pseudo');
$prenom = Systeme::_POST('prenom');
$nom = Systeme::_POST('nom');
$email = Systeme::_POST('email');
$password = Systeme::_POST('password');
$conf_password = Systeme::_POST('conf-password');

if ($pseudo == false or $prenom == false or $nom == false or $email == false or $password == false or $conf_password == false) {
	//Si les informations ne sont pas remplies
	header("location: ./index.php?erreur=2");
	exit;
}

Systeme::Init();

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header("location: ./index.php?erreur=4");
	exit;
}

if($password != $conf_password){
	header("location: ./index.php?erreur=3?");
	exit;
}

$user = new Utilisateur($pseudo, $prenom, $nom, $email, $password);
$err_code = Systeme::ajouterUtilisateur($user);

if ($err_code) {
	header("location: ./index.php?erreur=1");
	exit;
}

if (Systeme::seConnecter($user->email, $user->mdp)){
	// Redirection vers la page d'accueil
	header("location: ../Profil");   // Revenir à la page principale avec le compte de l'utilisateur à présent connecté
	exit;
} else {
	header("location: ../Login");
}
