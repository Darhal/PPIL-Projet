<?php

// Connexion
try {
	$bd = new SQLite3('BD.sqlite');
} catch (SQLiteException $e) {
	die("La création ou l'ouverture de la base a échouée ".
		"pour la raison suivante: ".$e->getMessage());
}

$login = $_POST['login'];

$result = $bd->query('SELECT * FROM utilisateur WHERE pseudo = "'.$login.'";');
$data = $result-> fetchArray();

if($data['id'] != "" ){		#Un compte avec ce pseudo existe déjà
	header('location: ../Inscription.php?erreur=1');
}
else{		#Le compte n'existe pas encore, création du compte

	if ($_POST['login'] != '' AND $_POST['password'] != '' ) { //Si les champs ne sont pas vides
	$login = $_POST['login'];
	$password = $_POST['password'];
	$nom = $_POST['nom'];
	$prenom  = $_POST['prenom'];
	$mail = $_POST['mail'];

    $bd->query('INSERT INTO utilisateur VALUES (NULL, "'.$login.'","'.$nom.'","'.$prenom.'","'.$mail.'","'.$password.'");');
	#   INSERT INTO utilisateur VALUES (NULL, 'louy','louy','louy','louy','louy');

	// Revenir à la page principale avec le compte de l'utilisateur à présent connecté
	#$_SESSION['login'] = $_POST['login'];
	header('location: index.html');

	}

}

#Fermeture Base
$bd->close();




