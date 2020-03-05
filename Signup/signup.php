<?php

$db = null;
try {
    $db = new SQLite3("../Assets/BD.sqlite");
} catch (SQLiteException $e) {
    die("Impossible d'ouvrir la base de données: " . $e->getMessage());
}


if ($_POST['pseudo'] != '' AND $_POST['prenom'] != '' AND $_POST['nom'] != '' AND $_POST['email'] != '' AND $_POST['password'] != '') { //Si les champs ne sont pas vides
    $login = $_POST['pseudo'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom  = $_POST['prenom'];
    $email = $_POST['email'];

    // Requête SQL pour tester si un utilisateur a déjà cette email
    $sql = "SELECT * FROM Utilisateur WHERE email = '" . $email . "'";
    $req = $db->querySingle($sql, true);

    if (count($req) > 0) {      // Un compte a déjà cette email
        header('location: index.php?erreur=1');
    }
    else {      //On peut créer le compte

        $sql = "INSERT INTO utilisateur VALUES(NULL,'".$login."','".$prenom."','".$nom."','".$email."','".$password."') ";

        $db->exec($sql);



        $sql = "SELECT * FROM Utilisateur WHERE email = '" . $email . "' AND mdp = '" . $password . "'";
        // Execution de la requête
        $req = $db->querySingle($sql, true);
        // Si un seul résultat
        if (count($req) > 0) {
            if (session_status() == PHP_SESSION_DISABLED) {
                session_start();
            }
            // On stocke les données dans la session
            $_SESSION["logged_in"] = true;
            $_SESSION["id"] = $req['idUtilisateur'];
            $_SESSION["username"] = $req['pseudo'];

            // Redirection vers la page d'accueil
            header('location: ../index.php');   // Revenir à la page principale avec le compte de l'utilisateur à présent connecté

        }
    }



}
else{     //Si les informations ne sont pas remplies
    header('location: index.php?erreur=2');
}

?>
