<?php


include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

session_start();

$text = "Connexion";
$target = "../Frontend/Login/";
$account = $target;
$tasks = $target;
$lists = $target;
if (Systeme::estConnecte()) {
	$text = "Déconnexion";
	$target = "../Frontend/Login/logout.php";
	$account = "../Profil";
	$tasks = "../Frontend/Tasks";
	$lists = "../Frontend/Lists";
}

echo '
<nav class="site-header sticky-top py-1">
	<div class="container align-center d-flex flex-column flex-md-row justify-content-between">
		<a class="py-1 d-none" href="/index.php">Accueil</a>
		<a class="py-1 d-none" href="'.$account.'">Mon compte</a>
		<a class="py-1 d-none" href="'.$lists.'">Mes listes</a>
		<a class="py-1 d-none disabled" href="'.$tasks.'">Mes tâches</a>
		<a class="py-1 d-none" href="'.$target.'">'.$text . '</a>
	</div>
</nav>';