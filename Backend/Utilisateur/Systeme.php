<?php

include_once "Utilisateur.php"; // This is okay they share the same folder
include_once getenv('PROJECT_PATH')."/Backend/DAO/DAOUtilisateur.php";

class Systeme
{
    private $arrayUtilisateurs = array();  // liste des Utilisateurs
    private $dao = null;
    private static $instance = null;


    private function __construct()
    {
        $this->dao = DAOUtilisateur::getInstance();
    }

    private function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    public function ajouterUtilisateurInstance(Utilisateur $utilisateur) {

    }
    
    public function ajouterUtilisateur(string $pseudo, string $prenom, string $nom, string $email, string $mdp) {
        $nouvelUtilisateur = new Utilisateur();  // c'est quoi le SessionID?
        $nouvelUtilisateur->setPseudo($pseudo);
        $nouvelUtilisateur->setPrenom($prenom);
        $nouvelUtilisateur->setNom($nom);
        $nouvelUtilisateur->setEmail($email);
        $nouvelUtilisateur->setMdp($mdp);

        array_push($this->arrayUtilisateurs, $nouvelUtilisateur);

        //Ajouter l'utilisateur à la BDD
        $this->dao->ajouterDansBDD($nouvelUtilisateur);
        return $nouvelUtilisateur;
    }

    public function supprimerUtilisateur(int $utilisateurID) {

    }

    public function seConnecter(string $email, string $mdp) : bool {
        $req = $this->dao->getByRequete("email LIKE '".$email."' AND mdp LIKE '".$mdp."'");

        if (sizeof($req) == 0){
            return false;
        }

        return true;
    }

    public function seDeconnecter(int $idUtilisateur){
        // a remplir
    }
}

?>