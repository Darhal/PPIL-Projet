<?php
/*
 * Projet Procrast
 * Classe  InvitationListeTache
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une invitation qui concerne une liste de tâches
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
include_once "Invitation.php";

class InvitationListeTache extends Invitation {

    function __construct(string $message, int $idInviteur, int $idListe)
    {
        parent::__construct($message, $idInviteur, $idListe);
    }

}

?>