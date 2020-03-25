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

$user = Systeme::getUserByID($uid);

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("ID de liste non défini");
	header("location: ../");
	exit;
}

$lid = intval($lid);

if (!is_int($lid)) {
	error_log("L'ID de liste n'est pas valide");
	header("location: ../");
	exit;
}

$liste = Systeme::getListeTachesByID($lid);

if ($liste == null) {
	error_log("Liste d'ID " . $lid . " inexistante");
	header("location: ../");
	exit;
}

$owner = Systeme::getUserByID($liste->proprietaire);

$membres = Systeme::getMembres($liste);

if (!in_array($user, $membres)) {
	error_log("L'utilisateur $user->pseudo n'est pas membre de la liste $liste->id");
	header("location: ../");
	exit;
}

?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<script   src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../CSS/style.css">
	<title>Procrast - <?php echo $liste->nom; ?></title>
	<style>
		.form-control{
			border-style: solid;   /* Style de la bordure  */
			border-width: 1px;   /* Epaisseur de la bordure  */
			border-color: #dddddd;   /* Couleur de la bordure  */
			background-color: #eeeeee;   /* Couleur de fond */
			padding: 10px 10px 10px 10px;   /* Espace entre les bords et le contenu : haut droite bas gauche  */
		}
	</style>
</head>
<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Membres </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">

	<h2><?php echo $liste->nom; ?></h2>

	<?php

	function Liste(ListeTaches $listeTaches, Utilisateur $utilisateurConnecte, Utilisateur $proprietaire) {

		$membres = Systeme::getMembres($listeTaches);
		echo "
		<table class='table'>
			<thead>
				<tr>
					<th scope='col'> Pseudo </th>
					<th scope='col'> Mail </th>
		";

		if ($proprietaire->id == $utilisateurConnecte->id) {
			echo "<th scope='col'> Supprimer </th>";
		}

		echo "
				</tr>
			</thead>
			<tbody>
		";

		foreach ($membres as $membre) {
			echo "<tr>";
			Row($listeTaches, $utilisateurConnecte, $membre, $proprietaire);
			echo "</tr>";
		}

		echo "
			</tbody>
		</table>
		";
	}

	function Row(ListeTaches $listeTaches, Utilisateur $utilisateurConnecte, Utilisateur $utilisateur, Utilisateur $proprietaire) {
		Pseudo($utilisateur);
		EMail($utilisateur);

		if ($utilisateurConnecte->id == $proprietaire->id) {
			Supprimer($listeTaches, $utilisateur, $proprietaire);
		}
	}

	function ID(Utilisateur $utilisateur) {
		echo "<td scope='row'> $utilisateur->id </td>";
	}

	function Pseudo(Utilisateur $utilisateur) {
		echo "<td> $utilisateur->pseudo </td>";
	}

	function EMail(Utilisateur $utilisateur) {
		echo "<td> $utilisateur->email </td>";
	}

	function Supprimer(ListeTaches $listeTaches, Utilisateur $utilisateur, Utilisateur $proprietaire) {
		echo "
		<td>
			<form action='/Frontend/Lists/deleteUser.php' method='post'>";

		if ($utilisateur->id == $proprietaire->id) {
			echo "<input class='no-inter' type='image' name='delete' src='../../../Assets/Images/SVG/trash.slash.svg' style='width:2rem;' alt='Supprimer'>";
		} else {
			echo "<input type='image' name='delete' src='../../../Assets/Images/SVG/trash.svg' style='width:2rem;' alt='Supprimer'>";
		}

		echo "
				<label for='lid'></label><input hidden type='text' id='lid' name='lid' value='$listeTaches->id'>
				<label for='udeleteid'></label><input hidden type='text' id='udeleteid' name='udeleteid' value='$utilisateur->id'>
			</form>
		</td>";
	}

	Liste($liste, $user, $owner);

	if ($user->id == $liste->proprietaire) {
		echo "
			<div class='container align-center text-center'>
				<hr>
				<h2> Inviter des membres </h2>
				<div id='recherche'>
					<h5>Tapez le nom de la personne que vous souhaitez rechercher, plus cliquer sur le nom en dessous pour l'ajouter à votre liste</h5>
					<form class='formulaire'>
                        <input class='form-control' id='input_name' type='text' placeholder='Pseudo'/>
                        <!--<input type='submit' value='Ajouter!'>-->
                    </form>
				</div>
				<div id='personne'>
				</div>
			</div>
			
		";
	}
	?>
</div>
	<?php include_once "Shared/footer.php"; ?>
</body>
<script type='application/javascript'>

    input_name.oninput = function () {
		f(input_name.value);
    };

    function f(p) {
        $.ajax({
            type:'GET',
            url:'pseudoR.php',
            data:'pseudo=' + p,
            success: function (data) {
                //afficher(data)
	            succes(data);
            }
        });
    }

    function succes(v) {
        var list = document.getElementById('personne');
        list.innerHTML = '';

        var json = JSON.parse(v);
        json.forEach(element => {
            var item = document.createElement("button");
            item.innerText = element.pseudo;
            item.className = "list-group-item list-group-item-action";
            item.onclick = function () {
                if (confirm("vous souhaitez ajouter " + element.pseudo)){

                    $.ajax({
                        type: 'POST',
                        url: 'add_member.php',
                        dataType: 'json',
                        data: {
                            user: element.email,
                            lid: <?php echo $liste->id ?>
                        }
                    })
                }
            };

            list.appendChild(item);

        });
    }


    function afficher(data) {
        const divElement = document.getElementById('personne');
        if (divElement.childElementCount !== 0){
            var child = divElement.lastChild;
            while (child) {
                divElement.removeChild(child);
                child = divElement.lastChild;
            }
        }
        const json = JSON.parse(data);
        json.forEach(element => {
            const personne = document.createElement('button');
            const content = document.createTextNode(element.pseudo);
            personne.appendChild(content);
            personne.click(alert(element.pseudo));
            divElement.appendChild(personne);
        })

    }
    function ajout(pseudo) {
        confirm('vous souhaitez ajouter' + pseudo);
    }
</script>
