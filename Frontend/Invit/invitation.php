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
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="/Frontend/CSS/style.css">
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
    </style>
</head>

<body>
<?php include_once "Shared/navbar.php"; ?>
<div class="spacer"></div>
<a href="profile.php" class="retour">
    <span>Retour</span>
</a>
<h1 class="text-center"> Invitations </h1>
<div class="spacer"></div>
<table style="width: 90%" border="1" id="tableauNotif">
    <tr>
        <th style="width: 70%" bgcolor="#ffe4c4" > Invitations<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > Accepter</th>
        <th style="background:bisque" > Refuser</th>
    </tr>
    <tr>
        <th style="width: 70%" bgcolor="#ffe4c4" > Maela vous invite à participer à la liste x<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > <img src="./img/add.png" width="20px"></th>
        <th style="background:bisque" > <img src="./img/refus.png" width="20px"></th>
    </tr>
    <tr id="3">
        <th style="width: 70%" bgcolor="#ffe4c4"  > Maela vous invite à participer à la liste y<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > <img src="./img/add.png" width="20px" onclick="document.getElementById('tableauNotif').deleteRow(document.getElementById('3'))"></th>
        <th style="background:bisque" > <img src="./img/refus.png" width="20px"></th>
    </tr>
    <tr>
        <th style="width: 70%" bgcolor="#ffe4c4" > Maela vous invite à participer à la liste z<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > <img src="./img/add.png" width="20px"></th>
        <th style="background:bisque" > <img src="./img/refus.png" width="20px"></th>
    </tr>
    <tr>
        <th style="width: 70%" bgcolor="#ffe4c4" > Maela vous invite à participer à la liste a<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > <img src="./img/add.png" width="20px" ></th>
        <th style="background:bisque" > <img src="./img/refus.png" width="20px"></th>
    </tr>
    <tr>
        <th style="width: 70%" bgcolor="#ffe4c4" > Maela vous invite à participer à la liste b<FONT face="Times New Roman"></FONT></th>
        <th style="background:bisque" > <img src="./img/add.png" width="20px"></th>
        <th style="background:bisque" > <img src="./img/refus.png" width="20px"></th>
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
<script language="javascript">
    function supprimerligne(numL)
    {
        document.getElementById("tableauNotif").deleteRow(0);
    }
</script>
</html>