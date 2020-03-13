<?php

if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();
$user = Systeme::getUserByID($uid);

if ($user == null){
	die("ERROR: Unable to find user by ID");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Mot de passe</title>
	<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
	include_once getenv('BASE')."Shared/navbar.php";
?>
<div class="container align-center">
	<div class="spacer"></div>
	<h1 class="text-center"> Modifier son mot de passe </h1>
	<div class="container align-center">
		<form method="post" action="change_passwd.php">

			<div class="form-group">
				<h3> Mot de passe actuel </h3>
				<label for="old-password"></label><input class="form-control" type="password" id="old-password" name="old-password" required>
			</div>

			<div class="form-group">
				<h3> Nouveau mot de passe </h3>
				<label for="new-password"></label><input class="form-control" type="password" id="new-password" name="new-password" required>
			</div>

			<div class="form-group">
				<h3> Confirmer votre nouveau mot de passe </h3>
				<label for="conf-password"></label><input class="form-control" type="password" id="conf-password" name="conf-password" required>
			</div>
			<input type="submit" value="Modifier son mot de passe">
		</form>
		<button onclick="window.location.href='./edit.php'"> Retour </button>

		<!-- TODO: Demander à l'utisateur de confirmer les changements, sous forme d'un POPUP peût être. -->

		<?php
		if(isset($_GET['erreur'])){
			$err = $_GET['erreur'];
			if($err==1) {
				echo "<p style='color:red'>email déjà utilisé, veuillez changer </p>";
			}
			if($err==2) {
				echo "<p style='color:red'>Vous devez remplir les champs obligatoires </p>";
			}
		}
		?>


	</div>
</div>
<?php 
	include_once getenv('BASE')."Shared/footer.php";
?>
</body>
</html>