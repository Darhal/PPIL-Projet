<?php
include("ConnexionBD.php");
//include("../donnee/Donnees.inc.php");

$sql= "CREATE TABLE IF NOT EXISTS utilisateur(";
$sql .= "id int(11) NOT NULL auto_increment,";
$sql .= "login varchar(50) NOT NULL,";
$sql .= "password varchar(50) NOT NULL,";
$sql .= "prenom varchar(50),";
$sql .= "nom varchar(50),";
$sql .= "sexe varchar(1),";
$sql .= "mail varchar(50),";
$sql .= "dateNaissance date,";
$sql .= "adresse varchar(50),";
$sql .= "codePostal varchar(5) ,";
$sql .= "ville varchar(50),";
$sql .= "numTel varchar(10),";
$sql .= "PRIMARY KEY(id) )";

mysqli_query($mysqli,$sql) or die("Erreur creation de table utilisateur");  // Création de la table utilisateur

/*$sql= "CREATE TABLE IF NOT EXISTS `aliment` (";
$sql .= "`id` int(4) NOT NULL,";
$sql .= "`aliment` text NOT NULL,";
$sql .= "`sous_cat` text,";
$sql .= "`super_cat` text ,";
$sql .= "PRIMARY KEY  (`id`)";
$sql .= ") ENGINE=MyISAM;";
 
mysql_query($mysql,$sql) or die("Erreur creation de table Aliment");*/

/*$cmp=0;
$sql = "";
$cat ="";
$cmp2 = 0;
foreach($Hierarchie as $key => $value) {
	$sql .= "INSERT INTO aliment(id,aliment,sous_cat,super_cat)";
	$sql .= 'VALUES("'.$cmp.'","'.$key.'","';
	foreach($value as $key2 => $value2) {
		foreach($value2 as $key3 => $value3) {
			$cat .= $value3."-";
		}
		if(sizeof($value) == 1 and $key2 == "super_cat"){
				$sql .='",';
		}
		if($cmp2 != 1 and sizeof($value) == 2){
			$sql .= $cat.'","';
			$cmp2 += 1;
		}else{
			$sql .= $cat.'"';
		}	
		$cat="";
		if(sizeof($value) == 1 and $key2 == "sous_cat"){
			$sql .=',""';
		}
	}
	$cmp2 = 0;
	$sql .=');';
	print_r($sql);
	$cmp += 1;
	mysql_query($mysql,$sql) or die('Aucune donner a été creer');
	$sql = "";
}
//mysql_query($mysql,$sql) or die('Aucune donner a été creer');*/

mysqli_close($mysqli);
?>

