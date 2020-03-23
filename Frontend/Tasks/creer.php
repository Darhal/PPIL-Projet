<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()){
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$uid = $_SESSION["id"];

Systeme::Init();

$user = Systeme::getUserByID($uid);

if ($user == null){
	// TODO: - Afficher une erreur
	error_log("ERROR: Unable to find user by ID");
	header("location: ../Login/logout.php");
}

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("ID de liste non défini");
	header("location: ../Lists");
}

$lid = intval($lid);

if (!is_int($lid)) {
	// TODO: - Afficher une erreur
	error_log("L'ID de liste n'est pas valide");
	header("location: ../Lists");
}

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	error_log("Liste d'ID $lid inexistante");
	header("location: ../Lists/index.php?erreur=1");
}

if ($liste->proprietaire != $user->id) {
	error_log("L'utilisateur $user->pseudo n'est pas propriétaire de la liste $liste->id");
	header("location: ../Lists/View/index.php?id=$liste->id");
	exit;
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
	include_once "Shared/navbar.php";
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
				<label for="tname"></label><input class="form-control" type="text" id="tname" name="tname" required>
			</div>

			<div class="d-flex justify-content-between">
				<button type="button" onclick="window.location.href='../Lists/View/index.php?id=<?php echo $liste->id; ?>'"> Retour </button>
				<input type="submit" value="Ajouter">
			</div>
			<label for="lid"></label><input hidden type="text" id="lid" name="lid" value="<?php echo $liste->id; ?>">
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
	include_once "Shared/footer.php";
?>
</body>
</html>