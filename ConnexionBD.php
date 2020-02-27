<?php

// Connexion
try {
    $bd = new SQLite3('BD.sqlite');
} catch (SQLiteException $e) {
    die("La création ou l'ouverture de la base a échouée ".
        "pour la raison suivante: ".$e->getMessage());
}


$result = $bd->query("SELECT mdp FROM utilisateur WHERE pseudo='etu'");
var_dump($result);

// Deconnexion
$bd = null;
?>