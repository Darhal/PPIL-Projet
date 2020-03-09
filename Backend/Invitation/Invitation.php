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

	public $message;
    public $emetteur;
    public $destinataire;
    public $id;
    public $liste;

    function __construct(string $message, int $emetteur, int $destinataire, int $liste) {

    	$this->id = null;
    	$this->message = $message;
    	$this->emetteur = $emetteur;
    	$this->destinataire = $destinataire;
    	$this->liste = $liste;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

?>