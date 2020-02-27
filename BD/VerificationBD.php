<?php 
function exist($login,$password,$mysqli){

	$sql = 'SELECT * FROM utilisateur
			WHERE utilisateur.login = "'.$login.'";';
	$req = mysqli_query($mysqli, $sql) or die("Erreur de connexion");
	$data = mysqli_fetch_assoc($req);
	if($data['id'] != "" ){
		return 0;
	}else{	
		return 1;
	}
}



?>