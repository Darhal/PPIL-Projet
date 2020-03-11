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
    header("location: /Frontend/Login");
    exit;
}

$user = Systeme::getUserByEmail($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/Frontend/CSS/style.css">
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
        $notifications = Systeme::getNoifications($user);

        foreach ($notifications as $notifications) {
            $emetteur = Systeme::getUserByID($notifications->emetteur);

            echo "
			<tr>
				<th scope='row'> " . $notifications->id . "</th>
				<th scope='row'> " . $notifications->message . "</th>
				<th scope='row'> " . $emetteur->pseudo . "</th>
				<th scope='row' class='container w-30'><a href='supprimer.php?id=$notifications->id'><img src='/Assets/Images/refus.png' title='Supprimer' style='box-sizing: border-box;width: 5%;'></th>
			</tr>
			";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>