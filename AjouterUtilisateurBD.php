<?php

// Connexion
try {
	$bd = new SQLite3('BD.sqlite', 0666);
} catch (SQLiteException $e) {
	die("La création ou l'ouverture de la base a échouée ".
		"pour la raison suivante: ".$e->getMessage());
}


if ($_POST['login'] != '' AND $_POST['password'] != '' ) { //Si les champs ne sont pas vides
	$login = $_POST['login'];
	$password = $_POST['password'];
	$nom = $_POST['nom'];
	$prenom  = $_POST['prenom'];
	$mail = $_POST['mail'];
    echo(sprintf("INSERT INTO utilisateur VALUES (NULL, '%s','%s','%s','%s','%s');", $login, $nom, $prenom, $mail, $password));
    #$bd->exec("INSERT INTO utilisateur VALUES (NULL, 'test','test','test','test','test');");
    $bd->query(sprintf("INSERT INTO utilisateur VALUES (NULL, '%s','%s','%s','%s','%s');", $login, $nom, $prenom, $mail, $password));

	// Revenir à la page principale avec le compte de l'utilisateur à présent connecté
	#$_SESSION['login'] = $_POST['login'];
	#header('location: index.html');



}

#Fermeture Base
$bd->close();




