<?php

abstract class Notification {
    public $msg;
    public $dejaLu;
    public $listeTaches;
    public $idNotif;
    function __construct(string $message,bool $lu,int $liste)
    {
        $this->dejaLu=$lu;
        $this->msg = $message;
        $this->listeTaches=$liste;
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

?>