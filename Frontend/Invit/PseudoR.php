<?php
include "../../Backend/Utilisateur/Systeme.php";
if (isset($_GET["pseudo"])) {
    $pseuso = $_GET["pseudo"];
} else {
    $pseudo = "";
}
$systeme= new Systeme;
$tab=$systeme::getUsersByPseudo($pseudo);
foreach ($tab as $personne){
    echo "$personne";
}