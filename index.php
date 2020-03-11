<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/Frontend/CSS/style.css">
	<title>Procrast - Accueil</title>
    <style type="text/css">
        h4{
            color: gray;
        }
        p{
            color: gray;
            display: inline-flex;
            text-align: right;
        }

    </style>

</head>
<body>
<div class="spacer"></div>
<h1 class="text-center"> Procrast </h1>
<h4 class="text-center"> List now what you could do later </h4>
<h4 class="text-center"> Listez maintenant ce que vous pourriez faire plus tard </h4>
<div class="spacer"></div>

<div class="text-center">
    <img src="/Assets/Images/main.png" style="width:30%">
    <div class="d-flex-centered-row">
        <p> Déjà membre ?</p>
        <button onclick="window.location.href='/Frontend/Login'"> Se connecter </button>
    </div>
    <div class="d-flex-centered-row">
        <p> Pas encore inscrit ?  </p>
        <button onclick="window.location.href='Frontend/Signup'"> S'inscrire </button>
    </div>
</div>
</div>
<?php include_once "Shared/footer.php"; ?>
</body>
</html>