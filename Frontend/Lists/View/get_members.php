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

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Type de requête invalide";
	header( "refresh:5;url=/Frontend/Lists/creer.php" );
}

if (isset($_POST['pseudo'])) {
	$pseudo = SQLite3::escapeString($_POST['pseudo']);
	$pseudo = trim($pseudo);
} else {
	echo "Aucun pseudo défini";
	header("refresh:5;url=/Frontend/Lists/");
}

$list = Systeme::getUsersByPseudo($pseudo);

echo json_encode($list);