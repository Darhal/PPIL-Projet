<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}

include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();

if (!Systeme::estConnecte()) {
	header("location: ../Lists");
}

$current_userID = $_SESSION['id'];
$current_user = Systeme::getUserByID($current_userID);

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Type de requête invalide";
	header( "refresh:5;url=/Frontend/Lists" );
}

if (isset($_POST['lid'])) {
	$lid = SQLite3::escapeString($_POST['lid']);
	$lid = trim($lid);
} else {
	echo "ID de liste non défini";
	header("refresh:5;url=/Frontend/Lists/");
}

if (isset($_POST['user'])) {
	$umail = SQLite3::escapeString($_POST['user']);
	$umail = trim($umail);
} else {
	echo "Utilisateur à ajouter non défini";
	header("refresh:5;url=/Frontend/Lists/");
}

$user = Systeme::getUserByEmail($umail);

$liste = Systeme::getListeTachesByID($lid);

Systeme::inviterUtilisateur($liste, $current_user, $user);

header("location: ../");