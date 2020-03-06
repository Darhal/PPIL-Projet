<?php

include_once getenv('BASE')."Backend/DAO/DAO.php";

class DAOInvit extends DAO
{

    private static $tab_name = "Invitation";

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idInvit" => "INTEGER constraint Invitation_pk primary key autoincrement",
                "msg" => "varchar not null",
                "nature" => "varchar not null",
                "idListe" => "INTEGER constraint Invitation_Liste_idListe_fk references Liste",
                "idInviteur" => "INTEGER constraint Invitation_Utilisateur_idUtilisateur_fk references Utilisateur"
            )
        );
    }

    public function ajouterDansBDD($objet)
    {
        // TODO: Implement ajouterDansBDD() method.
    }

    public function supprimerDeBDD($objet)
    {
        // TODO: Implement supprimerDeBDD() method.
    }

    public function getByRequete($requete)
    {
        // TODO: Implement getByRequete() method.
    }
}