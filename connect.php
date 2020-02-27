<?php

//On démarre une nouvelle session
session_start();


if($_POST['login'] !== '' AND $_POST['password'] !== '') {  // Si les champs ne sont pas vides

	// Connexion
	try {
		$bd = new SQLite3('BD.sqlite');
	} catch (SQLiteException $e) {
		die("La création ou l'ouverture de la base a échouée ".
			"pour la raison suivante: ".$e->getMessage());
	}

	$login = $_POST['login'];
	$password = $_POST['password'];
	$result = $bd->query("SELECT count(*) FROM utilisateur WHERE pseudo='".$login."' and mdp = '".$password."'");
	$data = $result-> fetchArray();
	$count = $data['count(*)'];
	if($count != 0) { // login et password corrects
		$_SESSION['login'] = $_POST['login'];
		header('location: index.html');
	}
	else {
		header('location: Connexion.php?erreur=1'); // login et password incorrects
	}

}
else { // login et password incomplets
	header('location: Connexion.php?erreur=2'); // champ login ou password vides
}

//Fermeture bd
$bd->close();



