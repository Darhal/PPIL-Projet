<?php
set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::Init();

$pseudo = Systeme::_POST('pseudo');
$lid = Systeme::_POST('lid');

if ($pseudo == false or $lid == false) {
	die("{}");
}

$liste = Systeme::getListeTachesByID($lid);
$utilisateurs = Systeme::getUsersNonMembresByPseudo($pseudo, $liste);

echo json_encode($utilisateurs);