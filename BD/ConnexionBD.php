<?php
$host = ''; /* L'adresse du serveur */
$login = ''; /* Votre nom d'utilisateur */
$password = ''; /* Votre mot de passe */
$base = ''; /* Le nom de la base */
$mysqli="";
	
global $mysqli;  
$mysqli=mysqli_connect($host,$login,$password,$base) or die("Erreur de connexion");
//mysql_select_db($base, $mysqli);

?>
