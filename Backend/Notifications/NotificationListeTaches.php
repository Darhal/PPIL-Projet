<?php

include_once "Notification.php";

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


    function marquerCommeLu(){
        $this->dejaLu=true;
    }


}

?>