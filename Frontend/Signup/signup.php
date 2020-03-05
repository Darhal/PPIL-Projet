<?php

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Vérification si l'utilisateur est déjà connecté
$db = null;
try {
	$db = new SQLite3(getenv("ROOT") . "Assets/BD.sqlite");
} catch (SQLiteException $e) {
	die("Impossible d'ouvrir la base de données: " . $e->getMessage());
}

$pseudo = "";
$prenom = "";
$nom = "";
$email = "";
$password = "";
$error = "";