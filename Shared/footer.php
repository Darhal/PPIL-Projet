<?php

set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

$text = "not connected";
if(Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	$pseudo = $_SESSION["username"];
	$text = "connected as ".$pseudo;
}

echo "<footer><small class='sticky-bottom'></small></footer>";