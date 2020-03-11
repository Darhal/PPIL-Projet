<?php
echo "dans delete de list" ;
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

$uid = $_SESSION["id"];

// Requête SQL
if (Systeme::supprimerListeByID($uid)) {
    header("location: /Frontend/Lists");
} else {
    // TODO: - Erreur
    echo "erreur";
}

