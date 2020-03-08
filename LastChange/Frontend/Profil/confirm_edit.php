<?php

if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

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

if ($pseudo != "" && $pseudo != $logged_user->pseudo) {
	$logged_user->pseudo = $pseudo;
}

if ($prenom != "" && $prenom != $logged_user->prenom) {
	$logged_user->prenom = $prenom;
}

if ($nom != "" && $nom != $logged_user->nom) {
	$logged_user->nom = $nom;
}

if ($email != "" && $email != $logged_user->email) {
	$logged_user->email = $email;
}

//Systeme::updateUser($user);

header("location: /Frontend/Profil");
// TODO: - Vérifier le mot de passe de l'utilisateur lors de la modification