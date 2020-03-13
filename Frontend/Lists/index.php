<?php

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();

if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}

if(Systeme::estConnecte()){
	$uid = $_SESSION["id"];
} else {
	// Redirection vers la page d'accueil
	header("location: /Frontend/Login");
	exit;
}

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
            <th scope="col">Editer</th>
            <th scope="col">Supprimer</th>
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
					<th scope='row'>" . $list->id . "</th>
					<td id='nom_'. $list->id ><a href='/Frontend/Lists/View/index.php?id=" . $list->id . "'>" . $list->nom . "</a></td>
					<td id='proprio_'. $list->id >" . $np . "</td>
					<td id='debut_'. $list->id>" . date("d/m/y", intval($list->dateDebut)) . "</td>
					<td id='fin_'. $list->id>" . date("d/m/y", intval($list->dateFin)) . "</td>
					<td id='edit_'. $list->id>
					<form action='./editLists.php' method='post'>
                        <input type='image' name='edit' src='../../Assets/Images/edit.png' style='width:2rem;'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>
					</form>
					</td>
					<td id='delete_'. $list->id>
					<form action='./deleteList.php.php' method='post'>
					    <input type='image' name='delete' src='../../Assets/Images/delete.png' style='width:2rem;' disabled><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'>
					</form>
					</td>
					<td id='membre_'. $list->id>
					<form action='./View/membres.php' method='post'>
					    <input type='image' name='member' img src='../../Assets/Images/member.png' style='width:2rem;'><label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$list->id'></td>
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
<script type="text/javascript">
    function supprimerListe() {
        //recupere la colonne
        var td = event.target.parentNode;
        console.log(td.rowIndex)
        //test qu'on clique bien sur l'image
        if (td.innerHTML.startsWith("<img")){
            //recupere la ligne ou se situe la colonne
            var tr = td.parentNode; // the row to be removed
            tr.parentNode.removeChild(tr);
        }
        else{
            console.log('dans le esle') ;
        }
    }

</script>
<?php include_once getenv('BASE') . "Shared/footer.php"; ?>
</body>
</html>