<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(Systeme::estConnecte()){
    // Redirection vers la page d'accueil
    header("location: ../Profil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <title>Procrast - Se connecter</title>
    <style>
        h5 {
            text-decoration: underline;
            text-decoration-color: blue;
            color:blue;        }
    </style>
</head>
<body>

<div class="spacer"></div>
<h1 class="text-center"> Connexion </h1>
<div class="spacer"></div>

<form class="container auto" method="post" action="login.php">
    <div class="container-30 auto">
        <div class="form-group">
            <h2> Email </h2>
            <label for="email"></label><input class="form-control" type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <h2> Mot de passe </h2>
            <label for="password"></label><input class="form-control" type="password" id="password" name="password" required>
        </div>

        <?php

        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1) {
                echo "<p style='color:red'>Ce compte n'existe pas</p>";
            }
            if($err==2) {
                echo "<p style='color:red'>Vous devez remplir les champs obligatoires</p>";
            }
            if($err==3) {
                echo "<p style='color:red'>Le mot de passe rentré est mauvais</p>";
            }
        }

        ?>
        <div class="d-flex justify-content-between">
            <input type="button" value="Retour" onclick="window.location.href='../../index.php'">
            <input type="submit" value="Se connecter">
        </div>
    </div>
    <div>
        <div class="spacer"></div>
        <h5><a href="../Signup/">Pas encore inscrit? C'est par ici.</a></h5>
    </div>
</form>

<?php
include_once "Shared/footer.php";
?>
</body>
</html>