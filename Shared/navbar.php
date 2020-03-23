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
    $uid = $_SESSION["id"];

}
Systeme::Init();
$user = Systeme::getUserByID($uid);
$notif=Systeme::getNbNotifications($user->id);
$nbinvit=Systeme::getNbInvitationsByIDUser($user->id);
echo '
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.notification {
   text-decoration: none;
  padding: 10px 20px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification:hover {
  background: red;
}

.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}
</style>
</head>
<body>
<nav class="site-header sticky-top py-1">
	<div class="align-center d-flex flex-column flex-md-row justify-content-between" style="max-width: 80%">
		<a class="py-1 d-none" href="'.$account.'">Mon compte</a>
		<a class="py-1 d-none" href="'.$lists.'">Mes listes</a>
		<a class="notification "  href="'.$notification.'"><span>Notifications</span> <span class="badge">'.$notif.'</span></a>
		<a class="notification " href="'.$invit.'">Invitations <span class="badge">'.$nbinvit.'</span> </a>
		<a class="py-1 d-none" href="'.$target.'">'.$text . '</a>
	</div>
</nav>

</body>
</html>

';