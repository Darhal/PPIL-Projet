<?php
/*
 * Projet Procrast
 * Class Utilisateur
 * @author: Ali MIRMOHAMMADI & Jonathan Pierrel
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
    private $mdp;

    private $arrayListeTaches = array();


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

    function __toString()
    {
        return "Utilisateur. [Id = ". $this->id . " sessionID = " . $this->sessionID . " estConnecte = " . $this->estConnecte . " pseudo = " .  $this->pseudo . " prénom = " .  $this->prenom . " email = " .  $this->email. " mdp = " .  $this->mdp;
    }


    function verifierMDPEtSeConnecter(string $input){
        //on verifie si la valeur de MDP_hash est bien defini sinon on affiche un msg d'erreur
        $res=false;
        if(!isset($this->mdp)){
            echo "<br> Erreur:<br>Utilisateur:verifierMDPEtSeConnecter:la variable mdp est vide<br/>";
        }else{
            $res= ($input == $this->mdp);
        }
        $this->estConnecte=$res;
        return $res;
    }

    function ajouterListeDeTache(ListeTaches $liste){
        //il suffit d'ajouter/mettre a jour la table de Membre dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe ListTache

//        array_push($this->arrayListeTaches, $liste);

        //TODO --> ajouter à BDD à travers DAO ?

    }

    function supprimerListeDeTache(ListeTaches $liste){
        //il suffit d'ajouter/mettre a jour la table de Membre dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe ListTache

        //TODO

    }

    function ajouterInvitation(Invitation $invit){
        //il suffit d'ajouter/mettre a jour la table d'Invite dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Invitation

        //TODO
    }

    function supprimmerInvitation(Invitation $invit){
        //il suffit d'ajouter/mettre a jour la table d'Invite dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Invitation

        //TODO
    }

    function repondreInvitation(Invitation $invit, bool $reponse){
        //TODO
    }

    function ajouterNotification(Notification $notif){
        //il suffit d'ajouter/mettre a jour la table de Notifie  dans la BDD
        //il faut verifier si le parametre est de type int ou une instancee de classe Notification
        //normalement on n'a pas besoin de supprimer les notifs
        //TODO
    }

    //------------------------------------- GETTERS
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * @return bool
     */
    public function isEstSessionOwner(): bool
    {
        return $this->estSessionOwner;
    }

    /**
     * @return mixed
     */
    public function getEstConnecte()
    {
        return $this->estConnecte;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMdp()
    {
        return $this->mdp;
    }


    //------------------------------------- SETTERS
    /**
     * @param bool $estSessionOwner
     */
    public function setEstSessionOwner(bool $estSessionOwner): void
    {
        $this->estSessionOwner = $estSessionOwner;
    }

    /**
     * @param mixed $estConnecte
     */
    public function setEstConnecte(bool $estConnecte): void
    {
        $this->estConnecte = $estConnecte;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $mdp
     */
    public function setMdp($mdp): void
    {
        $this->mdp = $mdp;
    }


    //Getters & setters - ancienne version
//    function __get($nomDAttribut)
//    {
//        return $this->$nomDAttribut;
//    }
//    function __set($nomDAttribut, $value)
//    {
//        //impossible de modifier la variable id et sessionID après sa création (pour raisons de sécurité)
//        switch ($nomDAttribut){
//            case "nom":
//                $this->nom = $value;
//                break;
//            case "prenom":
//                $this->prenom = $value;
//                break;
//            case "pseudo":
//                $this->pseudo = $value;
//                break;
//            case "email":
//                $this->email = $value;
//                break;
//            case "mdp_hash":
//                $this->mdp_hash = $value;
//                break;
//            default:
//                echo "<br> Erreur:<br>Utilisateur:setter:Le nom d'attribut".$nomDAttribut." n'est pas correct.<br/>";
//                break;
//        }
//    }

}