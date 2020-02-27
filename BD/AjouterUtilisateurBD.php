<?php
include("ConnexionBD.php");
include("VerificationBD.php");

$exist = exist($_POST['login'],$_POST['password'],$mysqli);
 
if ($_POST['login'] != '' AND $_POST['password'] != '' and  $exist == 1) { //Si le compte n'existe pas déjà et que les champs ne sont pas vides
	$login = $_POST['login'];
	$password = $_POST['password'];
	$nom = $_POST['nom'];
	$prenom  = $_POST['prenom'];
	$mail = $_POST['mail'];
	
	$sql = "INSERT INTO utilisateur(login,password,prenom,nom,mail) ";
    $sql .= "VALUES ('".$login."','".$password."','".$prenom."','".$nom."','".$mail."');";

	mysqli_query($mysqli, $sql) or die('Echec insertion');  //Ajoute l'utilisateur à la table 'utilisateur' de la base de données

	// Revenir à la page principale avec le compte de l'utilisateur à présent connecté
	$_SESSION['login'] = $_POST['login'];
	header('location: ../index.html');

}
else  {	

	if($exist == 0){  //Si le compte existe déjà
		header('location: ../Inscription.php?erreur=1');
	}else{  //Si les informations ne sont pas remplies
		header('location: ../Inscription.php?erreur=2');
 
	}
    

}
mysqli_close($mysqli);
?>
