<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(!Systeme::estConnecte()){
	header("location: ../../Login");
	exit;
}

$uid = $_SESSION["id"];

include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Taches/ListeTaches.php";
include_once "Backend/Taches/Tache.php";

Systeme::Init();

$user = Systeme::getUserByID($uid);

$lid = Systeme::_GET('id');

if ($lid == false) {
	error_log("ID de liste non défini");
	header("location: ../");
	exit;
}

$lid = intval($lid);

if (!is_int($lid)) {
	error_log("L'ID de liste n'est pas valide");
	header("location: ../");
}

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	error_log("Liste d'ID " . $lid . " inexistante");
	header("location: ../");
}

$membres = Systeme::getMembres($liste);

if (!in_array($user, $membres)) {
	error_log("L'utilisateur $user->pseudo n'est pas membre de la liste $liste->id");
	header("location: ../");
	exit;
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
<?php include_once "Shared/navbar.php"; ?>
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

		<?php

		function Liste(ListeTaches $listeTaches, Utilisateur $utilisateur) {
			echo "<table class='table'><thead><tr>";

			echo "
				<th scope='col'> Item </th>
				<th scope='col'> Responsable </th>
				<th scope='col'> Complétée </th>
			";

			if ($listeTaches->proprietaire == $utilisateur->id) {
				echo "
					<th scope='col'> Editer </th>
					<th scope='col'> Supprimer </th>";
			}
			echo "</tr></thead><tbody>";

			$tasks = Systeme::getTasks($listeTaches);

			foreach ($tasks as $task) {
				Row($listeTaches, $task, $utilisateur);
			}

			echo "</tbody></table>";
		}

		function Row(ListeTaches $listeTaches, Tache $tache, Utilisateur $utilisateur) {
			echo "<tr>";
			Item($tache);
			Responsable($listeTaches, $tache, $utilisateur);
			Completee($listeTaches, $tache, $utilisateur);

			if ($listeTaches->proprietaire == $utilisateur->id) {
				Editer($tache);
				Supprimer($tache);
			}

			echo "</tr>";
		}

		function ID(Tache $tache) {
			echo "<th scope='row'> $tache->id </th>";
		}

		function Item(Tache $tache) {
			echo "<td> $tache->nom </td>";
		}

		function Responsable(ListeTaches $listeTaches, Tache $tache, Utilisateur $utilisateur) {
			if (empty($tache->responsable)) {
				// Pas de responsable
				echo "
					<td><form action='../../Tasks/enroll.php' method='post'>
						<input type='submit' value='Se porter volontaire'>
						<input type='hidden' value='$tache->id' name='tid' id='tid'>
					</form></td>";
			} else {
				// Un responsable
				if ($tache->responsable != $utilisateur->id) {
					// Pas moi
					$res_user = Systeme::getUserByID($tache->responsable);
					echo "<td class='d-flex justify-content-between'>";
					if ($res_user == null) {
						// Utilisateur inexistant
						echo "<p class='text-muted'> Ancien utilisateur </p>";
					} else {
						// Utilisateur existant
						echo "<p> $res_user->pseudo </p>";
					}

					if ($listeTaches->proprietaire == $utilisateur->id) {
						echo "
							<form action='../../Tasks/leave.php' method='post'>
								<input type='submit' value='Remercier'>
								<input type='hidden' value='$tache->id' name='tid' id='tid'> 
							</form>";
					}
					echo "</td>";
				} else {
					// Moi
					if ($tache->finie) {
						echo "<td><p> Moi </p></td>";
					} else {
						echo "
						<td><form action='../../Tasks/leave.php' method='post'>
							<input type='submit' value='Ne plus être responsable'>
							<input type='hidden' value='$tache->id' name='tid' id='tid'> 
						</form></td>";
					}
				}
			}
		}

		function Completee(ListeTaches $listeTaches, Tache $tache, Utilisateur $utilisateur) {
			if ($tache->responsable != $utilisateur->id and $listeTaches->proprietaire != $utilisateur->id) {
				// Pas responsable
				$res = $tache->finie ? 'oui' : 'non';
				echo "<td><p> $res </p></td>";
			} else {
				// Responsable
				if (!$tache->finie) {
					// Pas finie
					$finie = "
						<form action='../../Tasks/setDone.php' method='post'>
							<input type='submit' value='Marquer comme finie'>
							<input type='hidden' value='$tache->id' name='tid' id='tid'> 
						</form>";
				} else {
					// Finie
					$finie = "
						<form action='../../Tasks/setNotDone.php' method='post'>
							<input type='submit' value='Marquer comme non finie'>
							<input type='hidden' value='$tache->id' name='tid' id='tid'> 
						</form>";
				}
				echo "<td> $finie </td>";
			}
		}

		function Editer(Tache $tache) {
			echo "<td><a href='/Frontend/Tasks/edit.php?id=" . $tache->id . "' class='d-none'><input type='image' name='edit' src='../../../Assets/Images/SVG/pencil.svg' style='width:2rem;' alt='Editer'></td>";
		}

		function Supprimer(Tache $tache) {
			echo "<td><a href='/Frontend/Tasks/delete.php?id=" . $tache->id ."'><img src='../../../Assets/Images/SVG/trash.svg' style='width:2rem;'  alt='Supprimer'></a></td>";
		}

		Liste($liste, $user);

		if ($liste->proprietaire == $user->id) {
			echo "
			<div class=\"float-right\">
	    <form action=\"../../Tasks/creer.php\" method=\"post\">
		    <input type=\"submit\" value=\"Ajouter une tâche\">
		    <label for=\"lid\"></label><input hidden type=\"text\" id=\"lid\" name=\"lid\" value=\"<?php echo $liste->id; ?>\">
	    </form>
    </div>
			
			";
		}
		?>
</div>

<?php include_once "Shared/footer.php"; ?>
</body>
</html>