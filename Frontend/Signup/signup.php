<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();



if ($_POST['pseudo'] != '' AND $_POST['prenom'] != '' AND $_POST['nom'] != '' AND $_POST['email'] != '' AND $_POST['password'] != '' AND $_POST['conf-password'] != '') { //Si les champs ne sont pas vides
    Systeme::Init();

    $pseudo = SQLite3::escapeString($_POST['pseudo']);
    $prenom = SQLite3::escapeString($_POST['prenom']);
    $nom = SQLite3::escapeString($_POST['nom']);
    $email = SQLite3::escapeString($_POST['email']);

    $passwd = SQLite3::escapeString($_POST['password']);
    $passwd_conf = SQLite3::escapeString($_POST['conf-password']);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("location: ./index.php?erreur=4");
		exit;
	}

	if($passwd != $passwd_conf){
		header("location: ./index.php?erreur=3?");
		exit;
	}

    // TODO: - Protéger contre l'injection SQL
    $user = new Utilisateur($pseudo, $prenom, $nom, $email, $passwd);
    $err_code = Systeme::ajouterUtilisateur($user);

    if ($err_code) {
        header("location: ./index.php?erreur=1");
        exit;
    }

    if (Systeme::seConnecter($user->email, $user->mdp)){
        // Redirection vers la page d'accueil
        header("location: ../Profil");   // Revenir à la page principale avec le compte de l'utilisateur à présent connecté
        exit;
    }
} else {
    //Si les informations ne sont pas remplies
    header("location: ./index.php?erreur=2");
    exit;
}
