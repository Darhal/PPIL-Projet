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
</head>

<body>
<?php include_once getenv('BASE') . "Shared/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Notifications </h1>
<div class="spacer"></div>
<table style="width: 90%" border="1" id="tableauNotif">
    <tr>
        <th style="width: 70%"  > Notifications<FONT face="Times New Roman"></FONT></th>
        <th  > Supprimer</th>
    </tr>
    <tr>
        <th style="width: 70%"  > vous avez recu une demande pour rejoidre la liste x<FONT face="Times New Roman"></FONT></th>
        <th > <img src="/Assets/Images/delete.png" width="20px"></th>
    </tr>
    <tr id="3">
        <th style="width: 70%"  > vous avez recu une demande pour rejoidre la liste y<FONT face="Times New Roman"></FONT></th>
        <th > <img src="/Assets/Images/delete.png" width="20px" onclick="document.getElementById('tableauNotif').deleteRow(document.getElementById('3'))"></th>
    </tr>
    <tr>
        <th style="width: 70%"  > vous avez recu une demande pour rejoidre la liste z<FONT face="Times New Roman"></FONT></th>
        <th  > <img src="/Assets/Images/delete.png" width="20px"></th>
    </tr>
    <tr>
        <th style="width: 70%"  > vous avez recu une demande pour rejoidre la liste a<FONT face="Times New Roman"></FONT></th>
        <th > <img src="/Assets/Images/delete.png" width="20px" ></th>
    </tr>
    <tr>
        <th style="width: 70%"  > vous avez recu une demande pour rejoidre la liste b<FONT face="Times New Roman"></FONT></th>
        <th  > <img src="/Assets/Images/delete.png" width="20px"></th>
    </tr>
    <?php
    /*try {
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
    }*/
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