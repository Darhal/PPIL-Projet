<?php
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

$real_base = str_replace($_SERVER["DOCUMENT_ROOT"], "", getenv('BASE'));
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$text = "Connexion";
$target = $real_base."Frontend/Login/";
$account = $target;

if (Systeme::estConnecte()) {
    $text = "Déconnexion";
    $target = $real_base."Frontend/Login/logout.php";
    $account = $real_base."Frontend/Profil";
}

echo '
<nav class="site-header sticky-top py-1">
	<div class="align-center d-flex flex-column flex-md-row justify-content-between" style="max-width: 80%">
		<a class="py-1 d-none" href="'.$real_base.'index.php">Accueil</a>
		<a class="py-1 d-none" href="'.$account.'">Mon compte</a>
		<a class="py-1 d-none" href="'.$target.'">'.$text . '</a>
	</div>
</nav>';