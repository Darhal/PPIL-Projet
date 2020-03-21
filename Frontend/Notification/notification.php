<?php
include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if(Systeme::estConnecte()){
    $uid = $_SESSION["id"];
} else {
    // Redirection vers la page d'accueil
    header("location: ../Login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <title> Notifications </title>
</head>
<body>
<?php include_once getenv('BASE') . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Notifications </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">
    <h2> Mes notifications </h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"> ID </th>
            <th scope="col"> Message </th>
            <th scope="col"> Supprimer </th>
        </tr>
        </thead>

        <tbody>

        <?php
            $user = Systeme::getUserByEmail($_SESSION['email']);

            $notifTache = Systeme::getNotificationsTache($user->id) ;
            $notifList = Systeme::getNotificationsListe($user->id);

            $notifs = array_merge($notifTache, $notifList); //fusion des notifs

        foreach ($notifs as $notifT) {

            echo "
            
				<tr>
					<th scope='row'>" . $notifT->idNotif . "</th>
					<td>" . $notifT->msg . "</td>
					</td>
					<td id='delete_'. $notifT->idNotif>
					<form action='./supprimer.php' method='post'>
					    <input type='image' name='delete' src='../../Assets/Images/delete.png' style='width:2rem;' disabled><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$notifT->idNotif'>
					</form>
					</td>
					

				</tr>" ;
        }

        ?>
        </tbody>
    </table>
</div>
</body>
</html>