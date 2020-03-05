<?php
    include_once (getenv('BASE')."Backend/Utilisateur/Utilisateur.php");
    include_once (getenv('BASE')."Backend/Utilisateur/Systeme.php");

    //echo getenv('BASE');
    Systeme::Init();

    $user = new Utilisateur("pseudo2", "prenom2", "nom2", "email2", "mdp2");
    Systeme::ajouterUtilisateur($user);
    echo Systeme::seConnecter("email2", "mdp2");
?>