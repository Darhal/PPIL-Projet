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
                "id" => "INTEGER constraint Invitation_pk primary key autoincrement",
	            "emetteur" => "INTEGER constraint Invitation_Utilisateur_idUtilisateur_fk references Utilisateur",
	            "destinataire" => "INTEGER constraint Invitation_Utilisateur_idUtilisateur_fk references Utilisateur",
                "message" => "varchar not null",
                "idListe" => "INTEGER constraint Invitation_Liste_idListe_fk references Liste"
            )
        );
    }

    public function ajouterDansBDD($invitation)
    {
        $attribs = array(
            "id" => $invitation->id,
	        "emetteur" => $invitation->emetteur,
	        "destinataire" => $invitation->destinataire,
            "message" => $invitation->message,
            "idListe" => $invitation->idListe,
        );

        $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    public function supprimerDeBDD($invitation)
    {
        $this->BDD->deleteRow(self::$tab_name, "id = ".$invitation->id);
    }

    public function getByRequete($requete)
    {
	    return $this->BDD->fetchResults(self::$tab_name, "*", $requete);
    }

    public function updateBDD($invite, $condition = "")
    {
        $attribs = array(); // TODO: JUST FINISH THIS (Look at DAOUtilisateur and get some inspiration from there)
        $res = $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
        return $res;
    }

    public function getInvitationsFor(Utilisateur $utilisateur) {
    	return $this->getByRequete("destinataire = $utilisateur->id");
    }
}