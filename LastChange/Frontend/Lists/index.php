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

$user = Systeme::getUserByEmail($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
	<title>Procrast - Mes Listes</title>
</head>
<body>
<?php include_once getenv('BASE') . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Mes listes </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">

	<h2> Mes Listes </h2>

	<table class="table">
		<thead>
		<tr>
			<th scope="col"> ID </th>
			<th scope="col"> Nom </th>
			<th scope="col"> Propriétaire </th>
			<th scope="col"> Date de début </th>
			<th scope="col"> Date de fin </th>
			<th scope="col"> Lien </th>
		</tr>
		</thead>
		<tbody>
		<?php
		$lists = Systeme::getOwnedLists($user);

		foreach ($lists as $list) {

			$proprietaire = Systeme::getUserByID($list->proprietaire);
			if ($proprietaire != null) {
				$np = $proprietaire->nom;
			} else {
				$np = "Inconnu?";
			}

			echo "
				<tr>
					<th scope='row'>" . $list->id . "</th>
					<td>" . $list->nom . "</td>
					<td>" . $np . "</td>
					<td>" . date("d/m/y", intval($list->dateDebut)) . "</td>
					<td>" . date("d/m/y", intval($list->dateFin)) . "</td>
					<td><a href='/Frontend/Lists/View/index.php?id=" . $list->id . "'> Go </a></td>
				</tr>";
		}
		?>
		</tbody>
	</table>

	<div class="float-right">
		<button onclick="window.location.href='creer.php'"> Ajouter une liste </button>
	</div>

</div>

<?php include_once getenv('BASE') . "Shared/footer.php"; ?>
</body>
</html>