<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

include_once "Backend/Utilisateur/Utilisateur.php";

// Démarrage de la session
Systeme::start_session();

Systeme::Init();

// Vérification si l'utilisateur est déjà connecté
if(Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: ../Profil");
	exit;
}

$email = "";
$password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] != 'POST') { // Si la requête est de type POST
	header("location: index.php?erreur=2");
	exit;
}

$email = Systeme::_POST('email');
$password = Systeme::_POST('password');

if ($email == false or $password == false) {
	header("location: index.php?erreur=2");
	exit;
}

if (Systeme::seConnecter($email, $password)) {
	header("location: ../Profil"); // Redirection vers la page d'accueil
} else {
	header("location: index.php?erreur=1");
}
