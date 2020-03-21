<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

Systeme::Init();

if(Systeme::estConnecte()){
    $uid = $_SESSION["id"];
} else {
    // Redirection vers la page d'accueil
    header("location: ../Lists");
    exit;
}

include_once "Backend/Utilisateur/Utilisateur.php";

$tid = Systeme::_GET('id');

if ($tid == false) {
	error_log("ID de tâche non défini");
	header("location: ../Lists");
}

$tid = intval($tid);

if (!is_int($tid)) {
    error_log("ID $tid invalide");
	header("location: ../Lists");
}

$task = Systeme::getTaskById($tid);
if ($task == null) {
    error_log("Tâche d'ID " . $tid . " inexistante");
	header("location: ../Lists");
}

$list = Systeme::getListeTachesByID($task->idListe);

if ($list->proprietaire != $uid) {
	error_log("Utilisateur non propriétaire de la liste");
	header("location: ../Lists?id=$list->id");
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
	<h1 class="text-center"><?php echo $task->nom . " - " . $list->nom ?></h1>
    <div class="container align-center">
        <form method="post" action="confirm_editTask.php" onsubmit="return confirm('Confirmer les changements ?')">

            <div class="form-group">
                <h3> Nom </h3>
                <label for="nom"></label><input class="form-control" type="text" id="nom" name="nom" placeholder="<?php echo $task->nom?>"><input type="hidden" value="<?php echo $task->id; ?>" name="tid" id="tid">
            </div>

            <div class="d-flex container-fluid">
                <button type="button" onclick="window.location.href='../Lists/View/index.php?id=<?php echo $list->id; ?>'"> Retour </button>
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
<?php include_once "Shared/footer.php"; ?>
</body>
</html>