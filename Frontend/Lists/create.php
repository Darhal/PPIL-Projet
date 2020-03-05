<?php
// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Vérification si un utilisateur est connecté
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true) {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

try {
	$db = new SQLite3(getenv("BASE") . "Assets/BD.sqlite", SQLITE3_OPEN_READWRITE);
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
$sql = "INSERT INTO Liste (nom, dateDebut, dateFin, idUtilisateur) VALUES ('" . $nom . "', '" . $dateDebut . "', '" . $dateFin . "', '" . $uid . "')";
$res = $db->exec($sql);

header("location: /Frontend/Lists");