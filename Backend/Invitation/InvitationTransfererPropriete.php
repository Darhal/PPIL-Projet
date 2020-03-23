<?php
/*
 * Projet Procrast
 * Classe InvitationTransfererPropriete
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une invitation qui concerne transfert de propriété d'une liste
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
include_once "Invitation.php";

class InvitationTransfererPropriete extends Invitation {

    function __construct(string $message, int $emetteur, int $destinataire, int $liste)
    {
        parent::__construct(SQLite3::escapeString($message), $emetteur, $destinataire, $liste);
    }

}

?>