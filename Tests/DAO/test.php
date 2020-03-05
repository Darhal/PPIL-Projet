<?php
    include_once (getenv('PROJECT_PATH')."/Backend/Utilisateur/Utilisateur.php");
    include_once (getenv('PROJECT_PATH')."/Backend/Utilisateur/Systeme.php");

    Systeme::Init();

    $user = new Utilisateur();
    $user->pseudo = "pseudo1";
    $user->prenom = "prenom1";
    $user->nom = "nom1";
    $user->email = "email1";
    $user->mdp = "mdp1";
    Systeme::ajouterUtilisateur($user);
    echo Systeme::seConnecter("email1", "mdp1");
?>