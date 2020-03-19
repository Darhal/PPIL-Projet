<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();
$real_base = str_replace($_SERVER["DOCUMENT_ROOT"], "", getenv('BASE'));

$text = "Connexion";
$target = $real_base."Frontend/Login/";
$account = $target;
$tasks = $target;
$lists = $target;
$invit = $target;
if (Systeme::estConnecte()) {
    $text = "Déconnexion";
    $target = $real_base."Frontend/Login/logout.php";
    $account = $real_base."Frontend/Profil";
    $tasks = $real_base."Frontend/Tasks";
    $lists = $real_base."Frontend/Lists";
    $notification = $real_base."Frontend/Notification/notification.php";
    $invit = $real_base."Frontend/Invit/invitation.php";
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