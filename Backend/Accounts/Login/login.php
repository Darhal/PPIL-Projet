<?php

include_once "../../Systeme.php";

if (isset($_GET['help'])) {
    echo "Paramètres attendus:</br>
    - email: l'adresse mail de l'utilisateur</br>
    - password: le mot de passe de l'utilisateur</br>
    - redirect: l'url vers laquelle rediriger en cas de connexion réussie</br>";

    foreach ($_POST as $key => $value) {
        echo "Field " . htmlspecialchars($key) . " is " . htmlspecialchars($value) . "<br>";
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
}

if (($email != "") && ($password != "")) {
    $sys = Systeme::getInstance();

    $sys->seConnecter($email, $password);
}

