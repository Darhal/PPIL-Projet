<?php set_include_path("/var/www/live.ugocottin.fr/"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>S'inscrire</title>
	<link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include_once "Assets/navbar.php"; ?>
<div class="container">
	<div class="spacer"></div>
	<h1 class="text-center"> Inscription </h1>
	<div class="container-30 center-div">
		<form method="post" action="signup.php">

			<div class="form-group">
				<h3> Pseudo </h3>
				<label for="pseudo"></label><input class="form-control" type="text" id="pseudo" name="pseudo">
			</div>

			<div class="form-group">
				<h3> Prénom </h3>
				<label for="prenom"></label><input class="form-control" type="text" id="prenom" name="prenom">
			</div>

			<div class="form-group">
				<h3> Nom </h3>
				<label for="nom"></label><input class="form-control" type="text" id="nom" name="nom">
			</div>

			<div class="form-group">
				<h3> Email </h3>
				<label for="email"></label><input class="form-control" type="email" id="email" name="email">
			</div>

			<div class="form-group">
				<h3> Mot de passe </h3>
				<label for="password"></label><input class="form-control" type="password" id="password" name="password">
			</div>

			<div class="form-group">
				<h3> Confirmer le mot de passe </h3>
				<label for="conf-password"></label><input class="form-control" type="password" id="conf-password">
			</div>

			<input type="submit" value="S'inscrire">
		</form>
		<button onclick="window.location.href='/'"> Retour </button>
	</div>
</div>
<?php include_once "Assets/footer.php"; ?>
</body>
</html>