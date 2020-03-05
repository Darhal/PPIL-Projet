<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	// Redirection vers la page d'accueil
	header("location: /Frontend/Profil");
	exit;
}

$email = "";
$password = "";
$error = "";

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['email'])) {
		$email = SQLite3::escapeString($_POST['email']);
		$email = trim($email);
	}

	if (isset($_POST['password'])) {
		$password = SQLite3::escapeString($_POST['password']);
		$password = trim($password);
	}

	// Si l'email et le mot de passe sont définis
	if (($email != "") && ($password != "")) {
		Systeme::Init();
		
		if (Systeme::seConnecter($email, $password)) {

			if (session_status() == PHP_SESSION_DISABLED) {
				session_start();
			}

			// On stocke les données dans la session
			$_SESSION["logged_in"] = true;
			$_SESSION["id"] = $req['idUtilisateur'];
			$_SESSION["username"] = $req['pseudo'];

			// Redirection vers la page d'accueil
			header("location: /Frontend/Profil");
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
header("location: /Frontend/Login");
