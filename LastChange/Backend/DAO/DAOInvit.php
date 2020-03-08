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

    public function ajouterDansBDD($invitation)
    {
        $attribs = array(
            "idInvit" => $invitation->id,
            "msg" => $invitation->msg,
            "nature" => $invitation->nature,
        );

        if($invitation->liste != null){
            $attribs["idListe"] = $invitation->liste->id;
        }

        if($invitation->inviteur != null){
            $attribs["idInviteur"] = $invitation->inviteur->id;
        }

        $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    public function supprimerDeBDD($invitation)
    {
        $this->BDD->deleteRow($this->tab_name, "idInvit = ".$invitation->id);
    }

    public function getByRequete($requete)
    {
        // TODO: Implement getByRequete() method.
    }
}