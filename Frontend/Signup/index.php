<?php set_include_path(getenv('BASE')); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>S'inscrire</title>
	<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
	include_once "Shared/navbar.php";
?>
<div class="container align-center">
	<div class="spacer"></div>
	<h1 class="text-center"> Inscription </h1>
	<div class="container align-center">
		<form method="post" action="signup.php" onsubmit="return ValidateEmail()">

			<div class="form-group">
				<h3> Pseudo </h3>
				<label for="pseudo"></label><input class="form-control" type="text" id="pseudo" name="pseudo" required>
			</div>

			<div class="form-group">
				<h3> Prénom </h3>
				<label for="prenom"></label><input class="form-control" type="text" id="prenom" name="prenom" required>
			</div>

			<div class="form-group">
				<h3> Nom </h3>
				<label for="nom"></label><input class="form-control" type="text" id="nom" name="nom" required>
			</div>

			<div class="form-group">
				<h3> Email </h3>
				<label for="email"></label><input class="form-control" type="email" id="email" name="email" required>
			</div>

			<div class="form-group">
				<h3> Mot de passe </h3>
				<label for="password"></label><input class="form-control" type="password" id="password" name="password" required>
			</div>

			<div class="form-group">
				<h3> Confirmer le mot de passe </h3>
				<label for="conf-password"></label><input class="form-control" type="password" id="conf-password" required>
			</div>

			<input type="submit" value="S'inscrire">
		</form>

		<?php
		if(isset($_GET['erreur'])){
			$err = $_GET['erreur'];
			if($err==1) {
				echo "<p style='color:red'>email déjà utilisée, veuillez changer </p>";
			}
			if($err==2) {
				echo "<p style='color:red'>Vous devez remplir les champs obligatoires </p>";
			}
		}
		?>

		<button onclick="window.location.href='/'"> Retour </button>
	</div>
</div>
<?php 
	include_once "Shared/footer.php";
?>
<script type="application/javascript">

    /**
     * @return {boolean}
     */
    function ValidateEmail()
    {
        const mail = document.getElementById('email').value;
        if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            alert("Format de l'email invalide");
            return false;
        } else {
            return true;
        }
    }

</script>
</body>
</html>