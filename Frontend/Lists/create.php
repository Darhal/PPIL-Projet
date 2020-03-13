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



// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

try {
	$db = new SQLite3(getenv("BASE") . "Assets/BD/db.sql", SQLITE3_OPEN_READWRITE);
} catch (SQLiteException $e) {
	die("Impossible d'ouvrir la base de données: " . $e->getMessage());
}

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Type de requête invalide";
	header( "refresh:5;url=/Frontend/Lists/creer.php" );
}

$uid = $_SESSION["id"];

if (isset($_POST['listName'])) {
	$nom = SQLite3::escapeString($_POST['listName']);
	$nom = trim($nom);
} else {
	echo "Aucun nom de liste";
	header("refresh:5;url=/Frontend/Lists/creer.php");
}

if (empty($nom)) {
	echo "nom de liste vide";
	header("refresh:5;url=/Frontend/Lists/creer.php");
}

if (isset($_POST['startingDate'])) {
	$dateDebut = SQLite3::escapeString($_POST['startingDate']);
	$dateDebut = trim($dateDebut);
} else {
	echo "Aucune date de début";
	header("refresh:5;url=/Frontend/Lists/creer.php");
}

if (isset($_POST['endingDate'])) {
	$dateFin = SQLite3::escapeString($_POST['endingDate']);
	$dateFin = trim($dateFin);
} else {
	echo "Aucune date de fin";
	header("refresh:5;url=/Frontend/Lists/creer.php");
}

// Requête SQL
if (Systeme::createList($nom, $dateDebut, $dateFin, $uid)) {
	header("location: /Frontend/Lists");
} else {
	// TODO: - Erreur
	echo "erreur";
}

