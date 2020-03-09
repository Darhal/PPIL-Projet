<?php
set_include_path(getenv('BASE'));
include_once "Backend/Utilisateur/Utilisateur.php";
include_once "Backend/Utilisateur/Systeme.php";

Systeme::start_session();

if ($_POST['pseudo'] != '' AND $_POST['prenom'] != '' AND $_POST['nom'] != '' AND $_POST['email'] != '' AND $_POST['password'] != '') { //Si les champs ne sont pas vides
    Systeme::Init();

    // TODO: - Protéger contre l'injection SQL
    $user = new Utilisateur($_POST['pseudo'], $_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['password']);
    $err_code = Systeme::ajouterUtilisateur($user);

    if ($err_code) {
        header("location: ../Signup/index.php?erreur=".$err_code);
        exit;
    }

    if (Systeme::seConnecter($user->email, $user->mdp)){
        // Redirection vers la page d'accueil
		header("location: ../Profil");   // Revenir à la page principale avec le compte de l'utilisateur à présent connecté
    }
} else {
    //Si les informations ne sont pas remplies
    echo "REDIR: ";
	header("location: ../Signup/index.php?erreur=2");
}
