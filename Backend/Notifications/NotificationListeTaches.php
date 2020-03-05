<?php

include_once "Notification.php";
include_once getenv('BASE')."Backend/Taches/Tache.php";
include_once getenv('BASE')."Backend/Taches/ListeTaches.php";

class NotificationListeTaches extends Notification
{
    function __construct(string $message,bool $lu,int $liste)
    {
        parent::__construct($message,$lu,$liste);
    }
    function __destruct()
    {
        parent::__destruct();
    }

    public function getListeTaches()
    {
        return $this->listeTaches;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
    }

    function marquerCommeLu(){
        $this->dejaLu=true;
    }

    function estLu(){
        return $this->dejaLu;
    }

    function setID(int $id){
        $this->idNotif=$id;
    }

    function getID(){
        return $this->idNotif;
    }

}

?>