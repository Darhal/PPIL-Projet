<?php

include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$text = "Connexion";
$target = "/Frontend/Login/";
$account = $target;


if (Systeme::estConnecte()) {
    $text = "Déconnexion";
    $target = "../Frontend/Login/logout.php";
    $account = "../Frontend/Profil";


}

echo '
<nav class="site-header sticky-top py-1">
	<div class="align-center d-flex flex-column flex-md-row justify-content-between" style="max-width: 80%">
		<a class="py-1 d-none" href="../index.php">Accueil</a>
		<a class="py-1 d-none" href="'.$account.'">Mon compte</a>
		<a class="py-1 d-none" href="'.$target.'">'.$text . '</a>
	</div>
</nav>';