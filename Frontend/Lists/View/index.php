<?php

session_start();

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Taches/ListeTaches.php");
include_once (getenv('BASE')."Backend/Taches/Tache.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();

$user = Systeme::getUserByEmail($_SESSION['email']);

if (!isset($_GET['id'])) {
	die("ID de liste non défini");
}

$lid = intval($_GET['id']);

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
    <link rel="stylesheet" type="text/css" href="../../CSS/style.css">
	<title>Procrast - <?php echo $liste->nom; ?></title>
</head>
<body>
<?php include_once getenv('BASE') . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Liste des tâches </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">


    <h2><?php echo $liste->nom; ?></h2>

	<table class="table">
		<thead>
		<tr>
			<th scope="col"> ID </th>
			<th scope="col"> Item </th>
			<th scope="col"> Responsable </th>
			<th scope="col"> Complété </th>
			<th scope="col"> Editer </th>
			<th scope="col"> Suppression </th>
		</tr>
		</thead>
		<tbody>
		<?php
		$tasks = null; //Systeme::getTasks($liste);

		foreach ($tasks as $task) {
			echo "
				<tr>
					<th scope='row'>" . $task->id . "</th>
					<td>" . $task->nom . "</td>
					<td>" . $task->responsable . "</td>
					<td>" . $task->finie . "</td>
					<td><a href='/Frontend/Task/edit.php?id=" . $task->id . "'> Go </a></td>
					<td><a href='/Frontend/Task/delete.php?id=" . $task->id . "'> Go </a></td>
				</tr>";
		}
		?>
		</tbody>
	</table>

    <div class="float-right">
	    <form action="../../Tasks/creer.php" method="post">
		    <input type="submit" value="Ajouter une tâche">
		    <input hidden type="text" id="lid" name="lid" value="<?php echo $liste->id; ?>">
	    </form>
    </div>

</div>

<?php include_once getenv("BASE") . "Shared/footer.php"; ?>
</body>
</html>