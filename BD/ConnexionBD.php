<?php
$host = 'sql.free.fr'; /* L'adresse du serveur */
$login = 'nicolas.bombarde'; /* Votre nom d'utilisateur */
$password = 'barpau54'; /* Votre mot de passe */
$base = 'nicolas.bombarde'; /* Le nom de la base */
$mysqli="";
	
global $mysqli;  
$mysqli=mysqli_connect($host,$login,$password,$base) or die("Erreur de connexion");
//mysql_select_db($base, $mysqli);

?>
