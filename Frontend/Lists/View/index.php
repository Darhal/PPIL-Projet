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

	<div class="d-flex container-fluid">
        <h2><?php echo $liste->nom; ?></h2>
		<form action="membres.php" method="post">
			<input type="submit" value="Voir les membres">
			<label for="lid"></label><input hidden type="text" id="lid" name="lid" value="<?php echo $liste->id; ?>">
		</form>
	</div>

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
		$tasks = Systeme::getTasks($liste);

		foreach ($tasks as $task) {

			// Reponsable, trois cas
			// 1 - Personne n'est responsable
			//  -> Tout le monde peut se proproser pour être responsable
			// 2 - Un utilisateur est responsable
			//  A - L'utilisateur connecté est responsable de la tâche
			//      -> Il peut se retirer de sa qualité de responsable
			//  B - L'utilsiateur connecté n'est pas responsable de la tâche
			//      -> Le nom du responsable lui est alors affiché

			// 1
			$responsable = "
<form action='../../Tasks/enroll.php' method='post'>
	<input type='submit' value='Volontaire'>
	<input type='hidden' value='$task->id' name='tid' id='tid'> 
</form>";

			// 2
			if ($task->responsable != "") {

				$resp_user = Systeme::getUserByID(intval($task->responsable));

				if ($resp_user == $user) {

					// A
					$responsable = "
						<form action='../../Tasks/leave.php' method='post'>
							<input type='submit' value='Ne plus être responsable'>
							<input type='hidden' value='$task->id' name='tid' id='tid'> 
						</form>";
				} else {
					// B
					$responsable = $resp_user->pseudo;
				}
			}

			// Statut de la tâche
			// 1 - L'utilisateur n'est pas responsable de la tâche
			//  -> Le statut de la tâche est affiché
			// 2 - L'utilisateur est responsable de la tâche
			//  A - La tâche n'est pas finie
			//      -> Il peut définir la tâche comme finie
			//  B - La tâche est finie
			//      -> Il peut invalider le statut de la tâche

			if ($task->responsable != $user->id) {
				// 1
				$finie = $task->finie ? "oui" : "non";
			} else {
				// 2
				if (!$task->finie) {
					// A
					$finie = "
						<form action='../../Tasks/setDone.php' method='post'>
							<input type='submit' value='Marquer comme finie'>
							<input type='hidden' value='$task->id' name='tid' id='tid'> 
						</form>";
				} else {
					// B
					$finie = "
						<form action='../../Tasks/setNotDone.php' method='post'>
							<input type='submit' value='Marquer comme non finie'>
							<input type='hidden' value='$task->id' name='tid' id='tid'> 
						</form>";
				}
			}

			echo "
				<tr>
					<th scope='row'>" . $task->id . "</th>
					<td>" . $task->nom . "</td>
					<td>" . $responsable . "</td>
					<td>" . $finie . "</td>
					<td><a href='/Frontend/Tasks/edit.php?id=" . $task->id . "'> Go </a></td>
					<td><a href='/Frontend/Tasks/delete.php?id=" . $task->id ."'> Go </a></td>
				</tr>";
		}
		?>
		</tbody>
	</table>

    <div class="float-right">
	    <form action="../../Tasks/creer.php" method="post">
		    <input type="submit" value="Ajouter une tâche">
		    <label for="lid"></label><input hidden type="text" id="lid" name="lid" value="<?php echo $liste->id; ?>">
	    </form>
    </div>

</div>

<?php include_once getenv("BASE") . "Shared/footer.php"; ?>
</body>
</html>