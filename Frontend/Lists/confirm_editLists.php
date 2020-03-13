<?php
set_include_path(getenv('BASE'));

include_once "Backend/Utilisateur/Systeme.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if(Systeme::estConnecte()){
    $uid = $_SESSION["id"];
} else {
    // Redirection vers la page d'accueil
    header("location: /Frontend/Lists");
    exit;
}

include_once "Backend/Utilisateur/Utilisateur.php";

Systeme::Init();

$lid = intval(SQLite3::escapeString($_POST['lid']));

if (!is_int($lid)) {

    die("L'ID de liste n'est pas valide");
}

$list = Systeme::getListeTachesByID($lid);

if ($list == null) {
    die("Liste d'ID " . $lid . " inexistante");
}

if (!isset($_POST['debut'])) {
    $debut = SQLite3::escapeString($_POST['debut']);
}


if (isset($_POST['fin'])) {
    $fin = SQLite3::escapeString($_POST['fin']);
}


if (!isset($_POST['nom'])) {
    die("nom non défini");
}

$nom = trim(SQLite3::escapeString($_POST['nom']));

if ($debut != "" && $debut != $list->dateDebut) {
    $list->dateDebut = $debut;
}

if (!empty($nom) && $nom != $list->$nom) {
    $list->nom = trim($nom);
}

if ($fin != "" && $fin != $list->dateFin) {
    $list->dateFin = $fin;
}

if (Systeme::updateList($list)) {
    header("location: /Frontend/Lists");
} else {
    header("location: edit.php?erreur=3");
}

// TODO: - Vérifier le mot de passe de l'utilisateur lors de la modification