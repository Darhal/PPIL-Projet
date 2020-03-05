<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

Systeme::Init();

// Vérification si l'utilisateur est déjà connecté
if(Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: /Frontend/Profil");
	exit;
}

$email = "";
$password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si la requête est de type POST
	if (($email != "") && ($password != "")) { // Si l'email et le mot de passe sont définis
		if (Systeme::seConnecter($email, $password)) {
			header("location: ".getenv('BASE')."/Frontend/Profil"); // Redirection vers la page d'accueil
		} else {
			$error = "Une erreur est survenue lors de la connexion (no user returned)";
		}
	} else {
		$error = "Impossible de récupérer l'adresse mail et/ou le mot de passe saisis";
	}
} else {
	$error = "Méthode invalide, POST attendu";
}

echo $error;
header("location: ".getenv('BASE')."/Frontend/Login");
