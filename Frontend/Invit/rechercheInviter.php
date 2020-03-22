<?php
session_start();
//include("../database/database.php");
set_include_path(getenv('BASE'));
$unwanted_array = array(
    'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
    'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
    'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <script   src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <style>
        .retour {
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
        .champ{
            border-style: solid;   /* Style de la bordure  */
            border-width: 1px;   /* Epaisseur de la bordure  */
            border-color: #dddddd;   /* Couleur de la bordure  */
            background-color: #eeeeee;   /* Couleur de fond */
            border-style: solid;   /* Style de la bordure  */
            border-width: 1px;   /* Epaisseur de la bordure  */
            border-color: #dddddd;   /* Couleur de la bordure  */
            padding: 10px 10px 10px 10px;   /* Espace entre les bords et le contenu : haut droite bas gauche  */
        }
    </style>
</head>

<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="spacer"></div>
<a href="profile.php" class="retour">
    <span>Retour</span>
</a>
<div id="recherche">

    <h1>Tapez le nom de la personne que vous souhaitez rechercher </h1>
    <form action="" class="formulaire">
        <input style="width: 300px" class="form-control" onchange="f(this.value)" type="text" placeholder="Pseudo"/>
        <input class="bouton" type="button"  value="rechercher" />

    </form>

</div>
<div id="personne">
</div>
<script type="application/javascript">
    function f(p) {
        $.ajax({
            type:"GET",
            url:"pseudoR.php",
            data:"pseudo="+p,
            success: function (data) {
                afficher(data)
            }
        });
    }
    function afficher(data) {
        var json = JSON.parse(data);
        var divElement = document.getElementById("personne");
        json.forEach(element => {
            var personne = document.createElement("div");
            var content = document.createTextNode(element.pseudo);
            personne.appendChild(content);
            document.body.insertBefore(personne, divElement);
        })
    }
</script>
