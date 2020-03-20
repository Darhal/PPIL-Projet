<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if(Systeme::estConnecte()){
    $uid = $_SESSION["id"];
} else {
    // Redirection vers la page d'accueil
    header("location: ./");
    exit;
}

include_once "Backend/Utilisateur/Utilisateur.php";

$lid = Systeme::_POST('lid');

if ($lid == false) {
	error_log("ID de liste non défini");
	header("location: ../Frontend/Lists");
}

$lid = intval($lid);

if (!is_int($lid)) {
    error_log("ID $lid invalide");
	header("location: ../Frontend/Lists");
}

$list = Systeme::getListeTachesByID($lid);
if ($list == null) {
    error_log("Liste d'ID " . $lid . " inexistante");
	header("location: ./");
}

if ($list->proprietaire != $uid) {
	error_log("Utilisateur non propriétaire de la liste");
	header("location: ./");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> Modifier les informations </title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php
include_once "Shared/navbar.php";
?>
<div class="container align-center">
    <div class="spacer"></div>
    <h1 class="text-center"> Modifier les informations </h1>
    <div class="container align-center">
        <form method="post" action="confirm_editLists.php" onsubmit="return verifyForm()">

            <div class="form-group">
                <h3> Nom </h3>
                <label for="nom"></label><input class="form-control" type="text" id="nom" name="nom" placeholder="<?php echo $list->nom?>"><input type="hidden" value="<?php echo $list->id; ?>" name="lid" id="lid">
            </div>


            <div class="form-group">
                <h3> Date de debut </h3>
                <label for="debut"></label><input class="form-control" type="date" id="debut" name="debut" value="<?php echo $list->placeholderDebut()?>">
            </div>

            <div class="form-group">
                <h3> (Date de fin) </h3>
                <label for="fin"></label><input class="form-control" type="date" id="fin" name="fin" value="<?php echo $list->placeholderFin()?>">
            </div>


            <div class="d-flex container-fluid">
                <button type="button" onclick="window.location.href='./'"> Retour </button>
                <input type="submit" value="Modifier les informations">
            </div>
        </form>

        <!-- TODO: Demander à l'utisateur de confirmer les changements, sous forme d'un POPUP peût être. -->

        <?php

        $err = Systeme::_GET('erreur');

        if($err != false){
            if($err==1) {
                echo "<p style='color:red'>Echec de l'update</p>";
            }
        }
        ?>

    </div>
</div>
<script type="text/javascript">

    function verifyForm() {

        let sdate = document.getElementById('debut');
        let startingDate = Date.parse(sdate.value);

        if (isNaN(startingDate)) {
            alert("Date de début invalide");
            return false;
        }

        let edate = document.getElementById('fin');

        if (edate.value === "") {
            return true;
        }

        let endingDate = Date.parse(edate.value);

        if (isNaN(endingDate)) {
            alert("Date de fin invalide");
            return false;
        }

        if (startingDate > endingDate) {
            alert("La date de fin ne peut précéder la date de début");
            return false;
        }

        return true;
    }

</script>

<?php
include_once "Shared/footer.php";
?>
</body>
</html>