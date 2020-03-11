<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../CSS/style.css">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<title>Créer une tâche</title>
</head>
<body>
<?php include_once getenv("BASE") . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Créer une liste de tâches </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">

	<form class="container auto" method="post" action="create.php" onsubmit="return verifyForm();" id="form">
		<div class="container-30 auto">
			<div class="form-group">
				<h2> Nom de la liste </h2>
				<label for="listName"></label><input class="form-control" type="text" id="listName" name="listName">
			</div>

			<div class="form-group">
				<h2> Date de début </h2>
				<label for="startingDate"></label><input class="form-control" type="date" id="startingDate" name="startingDate" placeholder="JJ/MM/YYYY">
			</div>

			<div class="form-group">
				<h2> Date de fin </h2>
				<label for="endingDate"></label><input class="form-control" type="date" id="endingDate" name="endingDate" placeholder="JJ/MM/YYYY">
			</div>

			<div class="d-flex justify-content-between">
				<button class="float-right" type="button" onclick="window.location.href='index.php'"> Annuler </button>
				<input type="submit" value="Créer!">
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

    $("#startingDate").datepicker({
        dateFormat: "dd/mm/yy"
    });

    $("#endingDate").datepicker({
        dateFormat: "dd/mm/yy"
    });

	function verifyForm() {

	    let listName = document.getElementById("listName");
        let res = listName.value.replace(/ /g, "");

        if (res.length <= 0) {
	        alert("Nom de liste invalide");
	        return false;
	    }

        if (document.getElementById("startingDate").value === "") {
            alert("Date de début vide");
            return false;
        }

        if (document.getElementById("endingDate").value === "") {
            alert("Date de fin vide");
            return false;
        }

        let startingDate = $("#startingDate").datepicker( "getDate" );

        let endingDate = $("#endingDate").datepicker( "getDate" );

        document.getElementById("startingDate").value = startingDate.getTime() / 1000;
        document.getElementById("endingDate").value = endingDate.getTime() / 1000;

	    return true;

	    //$('#form').submit();
	}

</script>
<?php include_once getenv("BASE") . "Shared/footer.php"; ?>
</body>
