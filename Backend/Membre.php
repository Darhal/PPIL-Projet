<?php
/*
 * Projet Procrast
 * Class Utilisateur
 * @author: Ali MIRMOHAMMADI & Jonathan Pierrel
 * @date:16/02/2020
 * @version: 1.0
 */

class Membre
{
    public $idListe;
    public $idUtilisateur;

    function __construct($idListe, $idUtilisateur)
    {
    	$this->idListe = $idListe;
    	$this->idUtilisateur = $idUtilisateur;
    }
}

?>