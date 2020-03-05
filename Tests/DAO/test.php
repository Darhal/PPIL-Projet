<?php
    include_once (getenv('PROJECT_PATH')."/Backend/Utilisateur/Utilisateur.php");
    include_once (getenv('PROJECT_PATH')."/Backend/Utilisateur/Systeme.php");

    // string $pseudo, string $prenom, string $nom, string $email, string $mdp
    $user = Systeme::getInstance()->ajouterUtilisateur(
        "pseudo", "prenom", "nom", "email", "mdp"
    );
    echo Systeme::getInstance()->seConnecter("email", "mdp");
?>