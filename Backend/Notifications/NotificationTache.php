<?php
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