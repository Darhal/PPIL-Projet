<?php
/*
 * Projet Procrast
 * Classe Abstraite Notification
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une notification et une variable boolean deja lu
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
abstract class Notification {
    public $msg;
    public $dejaLu;
    public $listeTaches;
    public $idNotif;
    public $destinataire; // id
    public $idTache;  // Seulement pour NotificationTache

    function __construct(string $message, bool $lu, int $idListe, int $idDestinaire)
    {
        $this->idNotif =null;
        $this->dejaLu=$lu;
        $this->msg = $message;
        $this->listeTaches=$idListe;
        $this->destinataire = $idDestinaire;
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

