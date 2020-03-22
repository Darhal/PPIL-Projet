<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::Init();
$user = Systeme::getUserByID($uid);

if ($user == null){
	header("location: ../Login/logout.php");
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
	include_once "Shared/navbar.php";
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
			<div class="d-flex justify-content-between">
				<button onclick="window.location.href='./edit.php'"> Retour </button>
				<input type="submit" value="Modifier son mot de passe">
			</div>
		</form>

		<!-- TODO: Demander à l'utisateur de confirmer les changements, sous forme d'un POPUP peût être. -->

		<?php
		if(isset($_GET['erreur'])){
			$err = $_GET['erreur'];
			switch ($err) {
				case 1:
					echo "<p style='color:red'>Vous devez remplir les champs obligatoires </p>";
					break;
				case 2:
					echo "<p style='color:red'>Le mot de passe actuel est faux </p>";
					break;
				case 3:
					echo "<p style='color:red'> Une erreur est survenue lors de la modification de votre mot de passe </p>";
					break;
				case 4:
					echo "<p style='color:red'> Les mots de passe saisis en correspondent pas </p>";
					break;
				default:
					echo "<p style='color:red'> Une erreur inconnue est survenue </p>";
					break;
			}
		}
		?>


	</div>
</div>
<?php 
	include_once "Shared/footer.php";
?>
</body>
</html>