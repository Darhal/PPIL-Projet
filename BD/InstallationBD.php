<?php
include("ConnexionBD.php");
//include("../donnee/Donnees.inc.php");

$sql= "CREATE TABLE IF NOT EXISTS utilisateur(";
$sql .= "id int(11) NOT NULL auto_increment,";
$sql .= "login varchar(50) NOT NULL,";
$sql .= "password varchar(50) NOT NULL,";
$sql .= "prenom varchar(50),";
$sql .= "nom varchar(50),";
$sql .= "mail varchar(50),";
$sql .= "PRIMARY KEY(id) )";

mysqli_query($mysqli,$sql) or die("Erreur creation de table utilisateur");  // Création de la table utilisateur


mysqli_close($mysqli);
?>

