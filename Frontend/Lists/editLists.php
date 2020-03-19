<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
    $uid = $_SESSION["id"];
} else {
    // Redirection vers la page d'accueil
    header("location: ./");
    exit;
}

include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

Systeme::Init();
$lid = intval(SQLite3::escapeString($_POST['lid']));

if (!is_int($lid)) {

    die("L'ID de liste n'est pas valide");
}

$list = Systeme::getListeTachesByID($lid);
if ($list == null) {
    die("Liste d'ID " . $lid . " inexistante");
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
include_once getenv('BASE')."Shared/navbar.php";
?>
<div class="container align-center">
    <div class="spacer"></div>
    <h1 class="text-center"> Modifier les informations </h1>
    <div class="container align-center">
        <form method="post" action="confirm_editLists.php">

            <div class="form-group">
                <h3> Nom </h3>
                <label for="nom"></label><input class="form-control" type="text" id="nom" name="nom" placeholder="<?php echo $list->nom?>" required><input type="hidden" value="<?php echo $list->id; ?>" name="lid" id="lid">
            </div>


            <div class="form-group">
                <h3> Date de debut </h3>
                <label for="debut"></label><input class="form-control" type="date" id="debut" name="debut" placeholder="<?php echo $list->dateDebut?>">
            </div>

            <div class="form-group">
                <h3> (Date de fin) </h3>
                <label for="fin"></label><input class="form-control" type="date" id="fin" name="fin" placeholder="<?php echo $list->dateFin?>">
            </div>


            <div class="d-flex container-fluid">
                <button type="button" onclick="window.location.href='./'"> Retour </button>
                <input type="submit" value="Modifier les informations">
            </div>
        </form>

        <!-- TODO: Demander à l'utisateur de confirmer les changements, sous forme d'un POPUP peût être. -->

        <?php
        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1) {
                echo "<p style='color:red'>Echec de l'update</p>";
            }
        }
        ?>

    </div>
</div>
<?php
include_once getenv('BASE')."Shared/footer.php";
?>
</body>
</html>