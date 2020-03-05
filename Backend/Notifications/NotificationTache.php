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
    function __construct(string $message,bool $lu,int $liste,int $tache)
    {
        parent::__construct($message,$lu,$liste);
        $this->tache=$tache;

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