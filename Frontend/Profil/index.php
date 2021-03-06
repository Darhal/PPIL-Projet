<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(Systeme::estConnecte()) {
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

Systeme::Init();
$user = Systeme::getUserByID($uid);

if ($user == null){
	error_log("ERROR: Unable to find user by ID");
	header("location: ../Login");
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../CSS/style.css">
	<title>Mon compte</title>
</head>
<body>
<?php include_once "Shared/navbar.php" ?>
<div class="spacer"></div>
<div class="container align-center">
	<div class="text-center">
		<img src="../../Assets/Images/SVG/Fichier%201.svg" class="w-30" alt="Profile Picture">
		<h1><?php echo ucfirst($user->prenom) . " " . ucfirst($user->nom)?></h1>
		<h4><?php echo ucfirst($user->pseudo) ?></h4>
		<p><?php echo ucfirst($user->email) ?></p>
		<div class="d-flex container-fluid">
			<form method="post" action="edit.php">
				<input type="submit" value="Modifier mon profil">
			</form>

			<form method="post" action="delete.php" onsubmit="return confirm('Êtes vous sur de vouloir supprimer votre compte ? Cela entraînera la suppression de toutes vos listes. Cette action est irréversible')">
				<input type="submit" value="Supprimer mon compte" style="color: red">
			</form>
		</div>
	</div>
</div>
</body>
<?php include_once "Shared/footer.php" ?>
</html>