<?php
include_once "Invitation.php";

class InvitationListeTache extends Invitation {

    function __construct(string $message, int $idInviteur, int $idListe)
    {
        parent::__construct($message, $idInviteur, $idListe);
    }

}

?>