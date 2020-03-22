<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()) {
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";

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
	<title>Modifier ses informations</title>
	<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="container align-center">
	<div class="spacer"></div>
	<h1 class="text-center"> Modifier ses informations </h1>
	<div class="container align-center">
		<form method="post" action="confirm_edit.php" onsubmit="return confirm('Confirmer ?')">

			<div class="form-group">
				<h3> Pseudo </h3>
				<label for="pseudo"></label><input class="form-control" type="text" id="pseudo" name="pseudo" placeholder="<?php echo $user->pseudo?>">
			</div>

			<div class="form-group">
				<h3> Prénom </h3>
				<label for="prenom"></label><input class="form-control" type="text" id="prenom" name="prenom" placeholder="<?php echo $user->prenom?>">
			</div>

			<div class="form-group">
				<h3> Nom </h3>
				<label for="nom"></label><input class="form-control" type="text" id="nom" name="nom" placeholder="<?php echo $user->nom?>">
			</div>

			<div class="form-group">
				<h3> Email </h3>
				<label for="email"></label><input class="form-control" type="email" id="email" name="email" placeholder="<?php echo $user->email?>">
			</div>

			<div class="form-group">
				<h3> Confirmer votre mot de passe </h3>
				<label for="conf-password"></label><input class="form-control" type="password" id="conf-password" name="conf-password">
			</div>
			<div class="d-flex container-fluid">
				<button type="button" onclick="window.location.href='./'"> Retour </button>
				<input type="submit" value="Modifier ses informations">
			</div>
		</form>

		<div class="spacer"></div>

		<form method="post" action="change_password.php">
			<input class="container" type="submit" value="Modifier son mot de passe" style="color: red">
		</form>

		<!-- TODO: Demander à l'utisateur de confirmer les changements, sous forme d'un POPUP peût être. -->

		<?php
		if(isset($_GET['erreur'])){
			$err = $_GET['erreur'];
			if($err==1) {
				echo "<p style='color:red'> Impossible d'utiliser l'adresse email entré </p>";
			}
			if($err==2) {
				echo "<p style='color:red'> Vous devez rentrer votre mot de passe </p>";
			}
            if($err==3) {
                echo "<p style='color:red'> Mot de passe invalide </p>";
            }
		}
		?>


	</div>
</div>
<?php include_once "Shared/footer.php"; ?>
</body>
</html>