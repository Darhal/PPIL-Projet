<?php
set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::Init();

$pseudo = Systeme::_GET('pseudo');

if ($pseudo == false) {
	die("{}");
}

$utilisateurs = Systeme::getUsersByPseudo($pseudo);

echo json_encode($utilisateurs);