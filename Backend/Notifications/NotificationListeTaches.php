<?php
/*
 * Projet Procrast
 * Classe  NotificationListeTaches
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une notification qui concerne une liste de tâches et une variable boolean deja lu
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
include_once "Notification.php";

class NotificationListeTaches extends Notification
{
    function __construct(string $message, bool $lu, int $idListe, int $idDestinatire)
    {
        parent::__construct($message,$lu,$idListe, $idDestinatire);
    }
    function __destruct()
    {
        parent::__destruct();
    }


    function marquerCommeLu(){
        $this->dejaLu=true;
    }


}

