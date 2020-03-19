<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

$text = "Connexion";
$target = "../Frontend/Login/";
$account = $target;
$tasks = $target;
$lists = $target;
$invit = $target;
if (Systeme::estConnecte()) {
    $text = "Déconnexion";
    $target = "../Frontend/Login/logout.php";
    $account = "../Frontend/Profil";
    $tasks = "../Frontend/Tasks";
    $lists = "../Frontend/Lists";
    $notification = "../Frontend/Notification/notification.php";
    $invit = "../Frontend/Invit/invitation.php";
}

echo '
<nav class="site-header sticky-top py-1">
	<div class="align-center d-flex flex-column flex-md-row justify-content-between" style="max-width: 80%">
		<a class="py-1 d-none" href="'.$account.'">Mon compte</a>
		<a class="py-1 d-none" href="'.$lists.'">Mes listes</a>
		<a class="py-1 d-none " href="'.$notification.'">Notifications </a>
		<a class="py-1 d-none " href="'.$invit.'">Invitations</a>
		<a class="py-1 d-none" href="'.$target.'">'.$text . '</a>
	</div>
</nav>';