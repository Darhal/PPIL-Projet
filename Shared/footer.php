<?php

session_start();

$text = "not connected";
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true){
	// Redirection vers la page d'accueil
	$id = $_SESSION["id"];

	try {
		$db = new SQLite3(getenv("BASE") . "Assets/BD.sqlite");

		$sql = /** @lang SQLite */
			"SELECT * FROM Utilisateur WHERE idUtilisateur = " . $id;
		// Execution de la requête
		$req = $db->querySingle($sql, true);

		$text = "connected as " . $req["pseudo"];

		$db->close();
	} catch (SQLiteException $e) {
		$text = "connected ?";
	}

}

echo "<footer><small class='sticky-bottom'> " . $text . " </small></footer>";