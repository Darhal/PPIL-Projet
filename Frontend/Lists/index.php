<?php set_include_path("/var/www/live.ugocottin.fr/");

session_start();

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/style.css">
	<title>Procrast - Mes Listes</title>
</head>
<body>
<?php include_once "Assets/navbar.php"; ?>
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

		$db = new SQLite3(getenv("ROOT") . "Assets/BD.sqlite");

		$sql = "SELECT * FROM Liste WHERE idUtilisateur = " . $uid;
		$req = $db->query($sql);
		while($row = $req->fetchArray(SQLITE3_ASSOC)) {

			$sql = /** @lang SQLite */
				"SELECT pseudo FROM Utilisateur WHERE idUtilisateur = " . $uid;
			$req_pseudo = $db->querySingle($sql);
			echo "
				<tr>
					<th scope='row'>" . $row["idListe"] . "</th>
					<td>" . $row["nom"] . "</td>
					<td>" . $req_pseudo . "</td>
					<td>" . date("d/m/y", intval($row["dateDebut"])) . "</td>
					<td>" . date("d/m/y", intval($row["dateFin"])) . "</td>
					<td><a class='disabled' href='/Frontend/Tasks/List?id=" . $row["idListe"] . "'> Go </td>
				</tr>";
		}

		$db->close();
		?>
		</tbody>
	</table>

	<div class="float-right">
		<button onclick="window.location.href='creer.php'"> Ajouter une liste </button>
	</div>

</div>

<?php include_once "Assets/footer.php"; ?>
</body>
</html>