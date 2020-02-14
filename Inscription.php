<?php
    //On démarre une nouvelle session
    session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">  
	
	body{
		background: #F0FFFF;
	}
	#conteneur{
		width:400px;
		margin:0 auto;
		margin-top:10%;
		border: 2px solid #ab4 ;
		background: #fff ;
	}
	form {
		//width:100%;
		padding: 30px;
		border: 1px solid #f1f1f1;
		background: #fff;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
		color: #008B8B ;
	}
	#container h1{
		width: 38%;
		margin: 0 auto;
		padding-bottom: 10px;
	}
	input[type=text], input[type=password] {
		width: 100%;
		padding: 12px 20px;
		margin: 8px 0;
		display: inline-block;
		border: 1px solid #ccc;
		box-sizing: border-box;
	}
	input[type=submit] {
		background-color: #008B8B;
		color: white;
		padding: 14px 20px;
		margin: 8px 0;
		border: none;
		cursor: pointer;
		width: 100%;
	}
	input[type=submit]:hover {
		background-color: white;
		color: #008B8B;
		border: 1px solid #53af57;
	}
	
	</style>

</head>

<body>
<?php include("index.html");?>
    



<div id="conteneur">
	<form name="formulaire" method="post" action="BD/AjouterUtilisateurBD.php">
	
	<h1>S'inscrire</h1>
	
	<label><b>Nom d'utilisateur<sup>*</sup></b></label>
	<input type="text" placeholder = "Entrer un nom d'utilisateur" name="login" id="login">

	
	<label><b>Mot de passe<sup>*</sup></b></label>
	<input type="password" placeholder = "Entrer un mot de passe" name="password" id="password">
	
	<label><b>Nom</b></label>
	<input type="text" name="nom" id="nom">
	
	<label><b>Prenom</b></label>
	<input type="text" name="prenom" id="prenom">
	
	
	<label><b>Sexe</b></label>
    <input type="radio" id="sex" name="sex" value="M" checked> Masculin
    <input type="radio" id="sex" name="sex" value="F"> Feminin
	</br>
	</br>
	
	
	<label><b>Adresse mail</b></label>
    <input type="text" id="mail" name="mail" value="">
	
	
	<label><b>Date de Naissance</b></label>
    <input type="date" id="daten" name="daten value="2018-07-22" "> 
    </br>
	</br>
	
	<label><b>Adresse</b></label>
    <input type="text" id="adr" name="adr" value="">
	
	
	<label><b>Code Postal</b></label>
    <input type="text" id="codepost" name="codepost" size ="5" value="">
	
	
	<label><b>Ville</b></label>
    <input type="text" id="ville" name="ville" value="">
	
	
	<label><b>Numero de Portable</b></label>	 
    <input type="text"  id="tel" name="tel" value="">
	
	<input type="submit" name="Submit" value="Envoyer" />
	<?php
        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1) {
                echo "<p style='color:red'>Login déjà utilisé, veuillez changer </p>";
			}
			if($err==2) {
				echo "<p style='color:red'>Vous devez remplir les champs obligatoires </p>";
			}
        }
    ?>
    </br>
    <sup>*</sup> Champ Obligatoire
	
	
	
	</form>
	
	
</div>




</body>

</html>
