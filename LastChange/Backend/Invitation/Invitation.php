<?php
/*
 * Projet Procrast
 * Classe Abstraite Invitation
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une invitation
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
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