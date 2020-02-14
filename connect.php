<?php
include("BD/ConnexionBD.php");

//On démarre une nouvelle session
session_start();


if($_POST['login'] !== '' AND $_POST['password'] !== '') {  // Si les champs ne sont pas vides

    // fonctions mysqli_real_escape_string et htmlspecialchars pour éliminer toute attaque de type injection SQL et XSS
    $login = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['login'])); 
    $password = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['password']));
	
	
	$sql = "SELECT count(*) FROM utilisateur
			WHERE login = '".$login."' and password = '".$password."' ";
	$req = mysqli_query($mysqli, $sql) or die("Erreur de connexion");
	$data = mysqli_fetch_array($req);
	
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
	header('location: Connexion.php?erreur=1'); // champ login ou password vides
}

mysqli_close($mysqli);
?>

