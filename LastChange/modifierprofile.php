<?php
session_start();
//include("../database/database.php");
$unwanted_array = array(
    'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
    'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
    'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="/Frontend/CSS/style.css">
    <style>
        form {
            margin: 0 auto;
            width: 400px;
            /* Encadré formulaire */
            padding: 1em;
            border: 1px solid #CCC;
            border-radius: 1em;
        }
        form div + div {
            margin-top: 1em;
        }

        label {
            display: inline-block;
            width: 120px;
            text-align: right;
        }
        .supprimer {
            background-color: #555;
            color: white;
            text-decoration: none;
            padding: 15px 26px;
            position: relative;
            display: inline-block;
            border-radius: 2px;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        


    </style>

</head>
<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h2 style="text-align:center">Mon Compte</h2>
<div class="spacer"></div>
<form action="/action_page.php">
    <label for="id">Pseudo: &nbsp;</label> <input type="text" id="id" name="id" value="Test"><br>
    <label for="fname">Prénom:&nbsp;</label><input type="text" id="fname" name="fname" value="test"><br>
    <label for="lname">Nom:&nbsp;</label><input type="text" id="lname" name="lname" value="test"><br>
    <label for="email">Adresse mail:&nbsp;</label> <input type="text" id="email" name="email" value="Test"><br>
    <label for="mdp">Mot de passe:&nbsp;</label><button>Changer mot de passe</button>
    <br><br>
    <button type="submit" value="Submit">Enregistrer</button>
    <button type="reset" value="Reset">Annuler</button>
</form>
<a href="supprimercompte.php" class="supprimer">
    <span>Supprimer le compte</span>
</a>

</body>
</html>