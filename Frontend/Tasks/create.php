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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Type de requête invalide";
	header( "refresh:5;url=../Lists" );
}

if (!isset($_POST['lid'])) {
	die("ID de liste non défini");
}

$lid = intval($_POST['lid']);

if (!is_int($lid)) {

	die("L'ID de liste n'est pas valide");
}

include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");
Systeme::Init();
$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	die("Liste d'ID " . $lid . " inexistante");
}

if (!isset($_POST['tname'])) {
	die("Nom de tâche non défini");
}

$tname = strval($_POST['tname']);

if (!is_string($tname)) {

	die("Le nom de tâche n'est pas valide");
}

include_once (getenv('BASE')."Backend/Taches/Tache.php");

$res = Systeme::createTask($tname, $liste);

if ($res == true) {
	echo "success";
	header("location: ../Lists/View/index.php?id=" . $liste->id);
} else {
	echo "failure";
}