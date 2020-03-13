<?php
echo "dans delete de list" ;
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();
//  ne marche pas
/*


Systeme::Init();

$lid = intval($_POST['lid']);

if (!is_int($lid)) {
    die("L'ID de liste n'est pas valide");
}
// Requête SQL

if (Systeme::supprimerListeByID($lid)) {
    header("location: /Frontend/Lists");
} else {
    // TODO: - Erreur
    echo "erreur";
}
*/
