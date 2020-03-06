<?php
include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

session_start();
$email = $_SESSION["email"];

$unwanted_array = array(
	'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
	'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
	'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
	'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
	'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
);

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

Systeme::Init();

$user = Systeme::getUserByID($uid);

if ($user == null){
	die("ERROR: Unable to find user by email");
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
<?php include_once getenv('BASE') . "Shared/navbar.php" ?>
<div class="spacer"></div>
<div class="container align-center">
	<div class="text-center">
		<img src="../../Assets/Images/SVG/Fichier%201.svg" class="w-30">
		<h1><?php echo ucfirst($user->prenom) . " " . ucfirst($user->nom)?></h1>
		<h4><?php echo ucfirst($user->pseudo) ?></h4>
		<p><?php echo ucfirst($user->email) ?></p>
		<div class="container">
			<button onclick="window.location.href='edit.php'"> Modifier le profil </button>
			<div>
			</div>
		</div>
	</div>
</div>
</body>
<?php include_once getenv('BASE') . "Shared/footer.php" ?>
</html>