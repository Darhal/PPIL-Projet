<?php

abstract class Invitation {
    public $msg;
    public $inviteur;
    public $liste;
    public $idInvitation;
    function __construct(string $message,int $idInviteur, int $idListe)
    {
        $this->msg=$message;
        $this->inviteur = $idInviteur;
        $this->liste=$idListe;

    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

?>