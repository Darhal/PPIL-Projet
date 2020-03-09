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

if (!isset($_POST['lid'])) {
	die("ID de liste non défini");
}

$lid = intval($_POST['lid']);

if (!is_int($lid)) {

	die("L'ID de liste n'est pas valide");
}

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	die("Liste d'ID " . $lid . " inexistante");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?php echo $liste->nom; ?></title>
	<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
	include_once getenv('BASE')."Shared/navbar.php";
?>
<div class="container align-center">
	<div class="spacer"></div>
	<h1 class="text-center"><?php echo $liste->nom; ?></h1>
	<h3 class="text-center"> Ajouter une tâche </h3>
	<div class="spacer"></div>
	<div class="container align-center">
		<form method="post" action="create.php">

			<div class="form-group">
				<h3> Nom de la tâche </h3>
				<label for="tname"></label><input class="form-control" type="text" id="tname" name="tname">
			</div>

			<div class="d-flex justify-content-between">
				<button onclick="window.location.href='../Profil'"> Retour </button>
				<input type="submit" value="Ajouter">
			</div>
			<input hidden type="text" id="lid" name="lid" value="<?php echo $liste->id; ?>">
		</form>

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