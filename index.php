<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/Frontend/CSS/style.css">
	<title>Procrast - Accueil</title>
</head>
<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Procrast </h1>
<div class="spacer"></div>

<div class="text-center">
	<div class="d-flex-centered-row">
		<p> Déjà membre ? </p>
		<button onclick="window.location.href='/Frontend/Login'"> Se connecter </button>
	</div>
	<div class="d-flex-centered-row">
		<p> Pas encore inscrit ? </p>
		<button onclick="window.location.href='Frontend/Signup'"> S'inscrire </button>
	</div>
</div>
<?php include_once "Shared/footer.php"; ?>
</body>
</html>