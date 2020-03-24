<?php
set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

// Démarrage de la session
Systeme::start_session();

Systeme::Init();

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	error_log("Type de requête invalide");
	echo "{}";
	exit;
}

$pseudo = Systeme::_POST('pseudo');

if ($pseudo == false) {
	error_log("Aucun pseudo défini");
	echo "{}";
	exit;
}

$pseudo = trim($pseudo);
$list = Systeme::getUsersByPseudo($pseudo);

echo json_encode($list);