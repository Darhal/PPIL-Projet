<?php

set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

// Vérification si un utilisateur est connecté
if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
	// TODO: - Afficher une erreur
	header( "location: ../Lists" );
}

if (!isset($_POST['id'])) {
	// TODO: - Afficher une erreur
	die("ID de tâche non défini");
}

$id = intval(SQLite3::escapeString($_POST['id']));
$lid = intval(SQLite3::escapeString($_POST['idListe']));
if (!is_int($id)) {
	// TODO: - Afficher une erreur
	die("L'ID de la tache n'est pas valide");
}

Systeme::Init();
$res = Systeme::supprimerTacheListe($id);

include_once "Backend/Taches/Tache.php";


if ($res == true) {
	header("location: ../Lists/View/index.php?id=" . $lid);
} else {
	// TODO: - Afficher une erreur
	echo "failure";
}