<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

// Démarrage de la session
if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si la requête est de type POST

	$email = $_POST['email'];
	$password = $_POST['password'];

	if (($email != "") && ($password != "")) { // Si l'email et le mot de passe sont définis
		if (Systeme::seConnecter($email, $password)) {
			header("location: ../Profil"); // Redirection vers la page d'accueil
		} else {
		    //si on peut recuperer un utilisateur avec le mail alors le mdp est faux
             if(Systeme::getUserByEmail($email)){
               header("location: index.php?erreur=3");
           }
           else {
               header("location: index.php?erreur=1");
           }
		}
	} else {
            header("location: index.php?erreur=2");
	}
} else {
	//$error = "Méthode invalide, POST attendu";
    header("location: index.php?erreur=2");
}

echo $error;
//header("location: ../Login?erreur");
