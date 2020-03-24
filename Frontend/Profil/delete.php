<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

$id = $_SESSION['id'];

$user = Systeme::getUserByID($id);

if ($user == null) {
	error_log("Aucun ID d'utilisateur");
	header("location: ../Login/logout.php");
}

Systeme::supprimerCompte($user);
header("location: ../Login/logout.php");