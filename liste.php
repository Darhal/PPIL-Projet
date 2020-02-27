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

<head>
    <link rel="stylesheet" href="../Styles/liste.css" media="screen" type="text/css" />
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<html>
<body>
<?php include "./menubar.php" ?>
<button class="favorite styled" type="button" onclick="ajouteLigne('TableA')">Ajouter une tâche</button>
</body>

<script type="text/javascript">

    function ajouteLigne(tableID) {

        /*On récupère le nom de la tache avec une boite de dialogue*/
        var nomTache = prompt("Nom de tâche : ");
        /*Cas d'annulation : on sort de la fonction*/
        if(nomTache == null){return 0;}

        /*Récupération d'une référence à la table*/
        var refTable = document.getElementById(tableID);

        /*Insère une ligne dans la table à l'indice de ligne 0*/
        var nouvelleLigne = refTable.insertRow(1);
        /*Insère une cellule dans la ligne à l'indice 0*/
        var nouvelleCellule = nouvelleLigne.insertCell(0);
        /*Ajoute le nom de la tache*/
        var nomNouvelleTache = document.createTextNode(nomTache)
        nouvelleCellule.appendChild(nomNouvelleTache);

        /*Insère une cellule dans la ligne à l'indice 2*/
        var nouvelleCellule = nouvelleLigne.insertCell(1);
        /* Ajoute le nom de lu responsable*/
        /*Créer le bouton éditer*/
        var nomResponsable = document.createElement('button');
        nomResponsable.innerHTML = 'Je suis volontaire';
        nouvelleCellule.appendChild(nomResponsable);

        /*Insère une cellule dans la ligne à l'indice 2*/
        var nouvelleCellule = nouvelleLigne.insertCell(2);

        /*Créer la check box*/
        var checkbox = document.createElement('input');

        // Assigning the attributes
        checkbox.type = "checkbox";
        checkbox.name = "name";
        checkbox.value = "value";
        checkbox.id = "id";
        /*Ajoute la checkbox*/
        nouvelleCellule.appendChild(checkbox);


        /*Insère une cellule dans la ligne à l'indice 3*/
        var editer = nouvelleLigne.insertCell(3);
        editer.innerHTML = '<img src="../images/edit.png"  style="width:20px;height:20px;" />';
        editer.onclick = editerTache;

        /*Insère une cellule dans la ligne à l'indice 4*/
        var suppression = nouvelleLigne.insertCell(4);
        suppression.innerHTML = '<img src="../images/delete.png"  style="width:20px;height:20px;"  />';
        suppression.onclick = supprimerTache;


    }

    function supprimerTache() {
        // event.target will be the input element.
        var td = event.target.parentNode;
        var tr = td.parentNode; // the row to be removed
        tr.parentNode.removeChild(tr);
    }

    function editerTache() {

    }


</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

    /*Permet de d'alterner les couleurs du tableau*/
    $(document).ready(function()
    {
        $("tr:odd").css({
            "background-color":"#BFBFBF" });
    });
</script>

</html>
