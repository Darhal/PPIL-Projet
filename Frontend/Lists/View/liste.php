<?php set_include_path("/var/www/ppil.ugocottin.fr/");

session_start();

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
    $uid = $_SESSION["id"];
    $idListe = $_POST["idListe"];
} else {
    // Redirection vers la page d'accueil
    header("location: /Frontend/Login");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/style.css">
    <title>Procrast - Liste - Name</title>
</head>
<body>
<?php include_once "Assets/navbar.php"; ?>
<div class="spacer"></div>
<h1 class="text-center"> Liste des tâches </h1>
<div class="spacer"></div>

<div class="container-fluid w-90 d-block">


    <h2> Liste<?php echo $idListe?></h2>

    <table class="table">
        <thead>
        <tr>
            <th scope="col"> Item </th>
            <th scope="col"> Responsable </th>
            <th scope="col"> Complété</th>
            <th scope="col"> Editer</th>
            <th scope="col"> Suppression </th>
        </tr>
        </thead>
        <tbody>
        <?php

        $db = new SQLite3(getenv("BASE") . "Assets/BD.sqlite");

        $sql = "SELECT * FROM Tache WHERE idUtilisateur = " . $uid;
        $req = $db->query($sql);
        while($row = $req->fetchArray(SQLITE3_ASSOC)) {

            /*Select le nom du responsable*/
            $sql = /** @lang SQLite */
                "SELECT idUtilisateur FROM Affecte WHERE idUtilisateur = " . $row["idTache"];
            $req_idUtilisateur = $db->querySingle($sql);
            $sql = /** @lang SQLite */
                "SELECT pseudo FROM Utilisateur WHERE idUtilisateur = " . $req_idUtilisateur;
            $req_responsable = $db->querySingle($sql);
            echo "
				<tr>
					<th scope='row'>" . $row["nom"] . "</th>
					<td>" . $req_responsable . "</td>
					<td> <input type='checkbox'> </td>
					<td>" . "</td>
					<td>"  . "</td>
				</tr>";
        }

        $db->close();
        ?>
        </tbody>
    </table>

    <a class="favorite styled" type="button">Ajouter une tâche</a>

    <div class="float-right">
        <button onclick="window.location.href='creer.php'"> Ajouter une liste </button>
    </div>

</div>

<?php include_once "Assets/footer.php"; ?>
</body>
</html>