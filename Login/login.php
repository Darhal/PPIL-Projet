<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true){
	// Redirection vers la page d'accueil
	header("location: ../Frontend/profile.php");
	exit;
}

$db = null;
try {
	$db = new SQLite3("../BD.sqlite");
} catch (SQLiteException $e) {
	die("Impossible d'ouvrir la base de données: " . $e->getMessage());
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
		// Requête SQL
		$sql = "SELECT * FROM Utilisateur WHERE email = '" . $email . "' AND mdp = '" . $password . "'";
		// Execution de la requête
		$req = $db->querySingle($sql, true);

		// Si un seul résultat
		if (count($req) > 0) {

			if (session_status() == PHP_SESSION_DISABLED) {
				session_start();
			}

			// On stocke les données dans la session
			$_SESSION["logged_in"] = true;
			$_SESSION["id"] = $req['idUtilisateur'];
			$_SESSION["username"] = $req['pseudo'];

			// Redirection vers la page d'accueil
			header("location: ../Frontend/profile.php");
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
header("location: index.php");