<?php
session_start();
//include("../database/database.php");
$unwanted_array = array(
    'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
    'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
    'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
	<style type="text/css">
	body{
		background: #F0FFFF;
	}
	form {
		//width:10%;
		padding: 3px;
		border: 1px solid #f1f1f1;
		background: #fff;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
		color: #008B8B ;
        border-radius: 20px;
	}
    form button{
        border: none;
        outline: 0;
        display: inline-block;
        padding: 5px;
        color: white;
        background-color: #555;
        width: 5%;
        font-size: 15px;
        border-radius: 20px;
    }
    .notification {
        background-color: #555;
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        position: relative;
        display: inline-block;
        left: 700px;
        border-radius: 2px;
    }
    .notification:hover {
        background: red;
    }
    .notification .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: red;
        color: white;
    }
    ul {
        background-color: #555;
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
    li {
        float: left;
    }
    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: #111;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
    }

    .title {
        color: grey;
        font-size: 18px;
    }

    button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #555;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }
    a {
        text-decoration: none;
        font-size: 22px;
        color: black;
    }

	</style>

</head>

<body>

<ul>
    <li><a class="active" href="#home">Acceuil</a></li>
    <li><a href="#">Profil</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#about">About</a></li>
</ul>


<!-- Search Wrapper -->
<div class="search-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#" method="post">
                    <input type="search" name="search" placeholder="Recherche personnes..">
                    <button type="submit"><i class="fa fa-search" aria-hidden="true">Ok</i></button>
                    <a href="#" class="notification">
                        <span>Notification</span>
                        <span class="badge">3</span>
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>
<h2 style="text-align:center"></h2>
<div class="card">
    <img src="img/index.png" style="width:100%">
    <h1>Prenom Nom</h1>
    <p class="title">CEO & Founder, Example</p>
    <p >Departement name</p>
    <p>Email : </p>
    <div style="margin: 24px 0;">
    <p><button>Modifier profile</button></p>
</div>


</body>
</html>