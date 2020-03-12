<?php
/*
 * Projet Procrast
 * Classe  NotificationListeTaches
 * L'implentation de "Design Pattern"s: Inheritance(Union)
 * cette classe contenir le message d'une notification qui concerne une tâche et une variable boolean deja lu
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
include_once "Notification.php";

class NotificationTache extends Notification {
    public $tache;
    function __construct(string $message, bool $lu, int $idListe, int $idTache, int $idDestinataire)
    {
        parent::__construct($message,$lu,$idListe, $idDestinataire);
        $this->tache=$idTache;

    }
    function __destruct()
    {
        parent::__destruct();
    }

    function marquerCommeLu(){
        $this->dejaLu=true;
    }


}

?>