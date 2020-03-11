<?php
echo "dans delete de list" ;
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();
//  ne marche pas

$id = $_POST['idList'] ;

// Requête SQL
if (Systeme::supprimerListeByID($id)) {
    header("location: /Frontend/Lists");
} else {
    // TODO: - Erreur
    echo "erreur";
}

