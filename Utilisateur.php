<?php
/*
 * Projet Procrast
 * Class Utilisateur
 * @author: Ali MIRMOHAMMADI
 * @date:16/02/2020
 * @version: 1.0
 */

class Utilisateur
{
    private $id;
    private $sessionID;
    private $estSessionOwner;
    private $estConnecte;
    private $pseudo;
    private $prenom;
    private $nom;
    private $email;
    private $mdp_hash;

    //avoir multiple constructeur n'est pas authorisé en php
    //on construit une instance d'Utilsiateur avec son identifiant et on verifie si l'Utilisateur connecté a une session ouverte
    //si la session est ouvert on vérifie la valeur d'element "id" dans la variable Globale session: si elle est même que l'identifiant donc l'utilisateur est le propriétaire de la session sinon il n'est pas connecté
    //une instance Untilisateur non-Connecté peut être crée
    function __construct($identifiant,$sessID)
    {
        //impossible de modifier la variable id et sessionID après sa création (pour raisons de sécurité)
        $this->id = $identifiant;
        $this->sessionID = $sessID;
        $this->estSessionOwner = ($identifiant==$sessID)? true:false;

    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    function __get($nomDAttribut)
    {
        return $this->$nomDAttribut;
    }
    function __set($nomDAttribut, $value)
    {
        //impossible de modifier la variable id et sessionID après sa création (pour raisons de sécurité)
        switch ($nomDAttribut){
            case "nom":
                $this->nom = $value;
                break;
            case "prenom":
                $this->prenom = $value;
                break;
            case "pseudo":
                $this->pseudo = $value;
                break;
            case "email":
                $this->email = $value;
                break;
            case "mdp_hash":
                $this->mdp_hash = $value;
                break;
            default:
                echo "<br> Erreur:<br>Utilisateur:setter:Le nom d'attribut".$nomDAttribut." n'est pas correct.<br/>";
                break;
        }

    }

    function verifierMDPEtSeConnecter($input){
        //on verifie si la valeur de MDP_hash est bien defini sinon on affiche un msg d'erreur
        $res=false;
        if(!isset($this->mdp_hash)){
            echo "<br> Erreur:<br>Utilisateur:verifierMDPEtSeConnecter:la variable mdp_hash est vide<br/>";
        }else{
            $res=password_verify($input,$this->mdp_hash);
        }
        $this->estConnecte=$res;
        return $res;
    }
    function ajouterListeDeTache($liste){
        //il suffit d'ajouter/mettre a jour la table de Membre dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe ListTache

        //TODO
    }

    function supprimerListeDeTache($liste){
        //il suffit d'ajouter/mettre a jour la table de Membre dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe ListTache

        //TODO
    }

    function ajouterInvitation($invit){
        //il suffit d'ajouter/mettre a jour la table d'Invite dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Invitation

        //TODO
    }

    function supprimmerInvitation($invit){
        //il suffit d'ajouter/mettre a jour la table d'Invite dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Invitation

        //TODO
    }

    function repondreInvitation($invit,$reponse){
        //TODO
    }

    function ajuoterNotification($notif){
        //il suffit d'ajouter/mettre a jour la table de Notifie  dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Notification
        //normalement on n'a pas besoin de supprimer les notifs
        //TODO
    }

}