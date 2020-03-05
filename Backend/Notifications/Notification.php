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