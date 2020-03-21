<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if(Systeme::estConnecte()){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: ../Login");
	exit;
}

$user = Systeme::getUserByID($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
	<title>Procrast - Mes Listes</title>
</head>
<body>
<?php include_once "Shared/navbar.php"; ?>
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
            <th scope="col">Editer</th>
            <th scope="col"> Supprimer / Quitter </th>
            <th scope="col">Membres</th>
		</tr>
		</thead>

        <tbody>
		<?php
		$lists = Systeme::getOwnedLists($user);
		$other = Systeme::getLists($user);
		if (count($other) > 0) {
			$lists = array_merge($lists, $other);
		}

		foreach ($lists as $list) {
			$proprietaire = Systeme::getUserByID($list->proprietaire);
			if ($proprietaire != null) {
				$np = $proprietaire->pseudo;
			} else {
				$np = "Inconnu?";
			}
			echo "
            
				<tr>
					<th scope='row'> $list->id </th>
					<td><a href='../Lists/View/index.php?id=$list->id'> $list->nom </a></td>
					<td> $np </td>
					<td>" . $list->formattedDebut() . "</td>
					<td>" . $list->formattedFin() . "</td>
					<td>";
					if ($proprietaire->id == $user->id) {
						echo "
						<form action='./editLists.php' method='post'>
							<input type='image' name='edit' src='../../Assets/Images/SVG/pencil.svg' style='width:2rem;' alt='Editer'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>";
					} else {
						echo "
						<form action='#' method='post'>
							<input class='no-inter' type='image' name='edit' src='../../Assets/Images/SVG/pencil.slash.svg' style='width:2rem;' alt='Editer désactivé' disabled><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>";
					}
					echo "</form>
					</td>
					<td>";
				if ($proprietaire->id == $user->id) {
					echo "
						<form action='./deleteList.php' method='post'>
							<input type='image' name='delete' src='../../Assets/Images/delete.png' style='width:2rem;' alt='Supprimer'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>";
				} else {
					echo "
						<form action='./leaveList.php' method='post'>
							<input type='image' name='leave' src='../../Assets/Images/SVG/exit.svg' style='width:2rem;' alt='Quitter'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>";
				}
					echo "</form>
					</td>
					<td>
					<form action='./View/membres.php' method='post'>
					    <input type='image' name='member' src='../../Assets/Images/member.png' style='width:2rem;' alt='Membres'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'></td>
				    </form>

				</tr>" ;

		}
		?>
		</tbody>
	</table>

	<div class="float-right">
		<button onclick="window.location.href='creer.php'"> Ajouter une liste </button>
	</div>
</div>
<?php include_once "Shared/footer.php"; ?>
</body>
</html>