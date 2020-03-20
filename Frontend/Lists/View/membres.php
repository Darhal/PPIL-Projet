<?php

set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if(!Systeme::estConnecte()) {
	// Redirection vers la page d'accueil
	header("location: ../../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Taches/ListeTaches.php";
include_once "Backend/Taches/Tache.php";

$user = Systeme::getUserByEmail($_SESSION['email']);

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

$owner = Systeme::getUserByID($liste->proprietaire);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/style.css">
	<title>Procrast - <?php echo $liste->nom; ?></title>
</head>
<body>
<?php include_once getenv('BASE') . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Membres </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">

	<h2><?php echo $liste->nom; ?></h2>

	<table class="table">
		<thead>
		<tr>
			<th scope="col"> ID </th>
			<th scope="col"> Pseudo </th>
			<th scope="col"> Mail </th>
			<?php if ($user->id == $owner->id) {
				echo "<th scope='col'> Supprimer </th>";
			}
			?>
		</tr>
		</thead>
		<tbody>
		<?php
		$membres = Systeme::getMembresInvites($liste);

		array_unshift( $membres, $owner);

		foreach ($membres as $membre) {
			$dis = '';

			echo "
				<tr>
					<th scope='row'>" . $membre->id . "</th>
					<td>" . $membre->pseudo . "</td>
					<td>" . $membre->email . "</td>";

			if ($user->id == $owner->id) {
				echo "<td><a href='/Frontend/Lists/View/delete.php?id=" . $membre->id . "'> Go </a></td>";
			}

			echo "</tr>";
		}
		?>
		</tbody>
	</table>

	<?php

	if ($user->id == $liste->proprietaire) {
		echo "
			<form method='post' action='add_member.php'>
				<label for='user'></label><select name='user' id='user'>";
		$users = Systeme::getUsersNonMembresByPseudo("", $liste);

		foreach ($users as $u) {
			echo "<option value='$u->email'> $u->pseudo </option>";
		}

		echo "</select>
		<input type='hidden' value='$liste->id' name='lid' id='lid'>
		<input type='submit' value='Ajouter!'>
		</form>";
	}
	?>
</div>

<?php include_once "Shared/footer.php"; ?>
</body>
</html>