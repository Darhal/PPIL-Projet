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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet" >
    <svg class="bi bi-chevron-right" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Notification</title>

</head>

<body>
    <?php include "./menubar.php" ?>
    <table style="width: 90%" border="1">
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > Notifications<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > Supprimer</th>
        </tr>
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > vous avez recu une demande pour rejoidre la liste x<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > <img src="./img/delete.png" width="20px"></th>
        </tr>
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > vous avez recu une demande pour rejoidre la liste y<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > <img src="./img/delete.png" width="20px"></th>
        </tr>
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > vous avez recu une demande pour rejoidre la liste z<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > <img src="./img/delete.png" width="20px"></th>
        </tr>
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > vous avez recu une demande pour rejoidre la liste a<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > <img src="./img/delete.png" width="20px" ></th>
        </tr>
        <tr>
            <th style="width: 70%" bgcolor="#ffe4c4" > vous avez recu une demande pour rejoidre la liste b<FONT face="Times New Roman"></FONT></th>
            <th style="background:bisque" > <img src="./img/delete.png" width="20px"></th>
        </tr>
        <?php
        try {
            $bd = new SQLite3('BD.sqlite');
        } catch (SQLiteException $e) {
            die("La création ou l'ouverture de la base a échouée ".
                "pour la raison suivante: ".$e->getMessage());
        }
        $notifications=$bd->query("SELECT msg FROM Notification n, Notifie noti where n.idNotif=noti.idNotif AND noti.idUtilisateur='".$_SESSION["id"]."'");
        $nbre=sqlite_num_rows($notifications);
        //creation du tableau
        $i=0;
        while ($val=sqlite_fetch_array($notifications)){
            $tab[$i]=$val['msg'];
            $i++;
        }
        //affichage
        if ($nbre!=0){
            for ($j=0;$j<$nbre;$j++){
                echo '<tr>';
                echo '<th style="width: 70%" bgcolor="#ffe4c4" >';
                echo $tab[$j];
                echo '</th>';
                echo '<th style="background:bisque" > ';

            }
        }

        ?>
    </table>


</body>
</html>
