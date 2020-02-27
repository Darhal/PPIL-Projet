<?php
    //On démarre une nouvelle session
    session_start();

?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

<div id="conteneur">
	<form name="formulaire" method="post" action="connect.php"> 
	
	<h1>Connexion</h1>
	
	<label><b>Nom d'utilisateur</b></label>
	<input type="text" placeholder = "Entrer le nom d'utilisateur" name="login" id="login" >

	
	<label><b>Mot de passe</b></label>
	<input type="password" placeholder = "Entrer le mot de passe" name="password" id="password">
	
	<input type="submit" name="Submit" value="Valider">
	<?php
        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1)
                echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
            if($err==2)
                echo "<p style='color:red'>Utilisateur ou mot de passe incomplet</p>";
        }
    ?>

	

	</form>
</div>



	



</body>
</html>
