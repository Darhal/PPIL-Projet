<?php
set_include_path("/var/www/ppil.ugocottin.fr/");

session_start();
$id = $_SESSION["id"];

$unwanted_array = array(
	'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
	'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
	'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
	'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
	'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
);

try {
	$db = new SQLite3(getenv("BASE") . "Assets/BD.sqlite");
} catch (SQLiteException $e) {
	die("Impossible d'ouvrir la base de données: " . $e->getMessage());
}

$sql = "SELECT * FROM Utilisateur WHERE idUtilisateur = " . $id;
$req = $db->querySingle($sql, true);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="CSS/style.css">
	<title>Mon compte</title>
</head>
<body>
<?php include_once "Assets/navbar.php" ?>
<div class="spacer"></div>
<div class="container align-center">
	<div class="text-center">
		<img src="/Assets/img/SVG/Fichier%201.svg" class="w-30">
		<h1><?php echo ucfirst($req['prenom']) . " " . ucfirst($req['nom'])?></h1>
		<h4><?php echo ucfirst($req["pseudo"]) ?></h4>
		<p><?php echo ucfirst($req["email"]) ?></p>
		<div class="container">
			<button onclick="window.location.href='edit.php'"> Modifier le profil </button>
			<div>
			</div>
		</div>
	</div>
</div>
</body>
<?php include_once "Assets/footer.php" ?>
</html>