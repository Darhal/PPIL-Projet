<?php
set_include_path("/var/www/ppil.ugocottin.fr/");

session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true){
	// Redirection vers la page d'accueil
	header("location: /Frontend/Profil");
	exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/style.css">
	<title>Procrast - Se connecter</title>
</head>
<body>
<?php include_once "Assets/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Connexion </h1>
<div class="spacer"></div>

<form class="container auto" method="post" action="login.php">
	<div class="container-30 auto">
		<div class="form-group">
			<h2> Email </h2>
			<label for="email"></label><input class="form-control" type="email" id="email" name="email">
		</div>

		<div class="form-group">
			<h2> Mot de passe </h2>
			<label for="password"></label><input class="form-control" type="password" id="password" name="password">
		</div>

		<input type="submit" value="Se connecter">
	</div>
</form>

<?php include_once "Assets/footer.php"; ?>
</body>
</html>