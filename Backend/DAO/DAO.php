<?php
/*
 * Projet Procrast
 * Class Singleton/Abstract DAO
 * L'implentation de "Design Pattern"s: Data access object, Singleton, Abstract Factory
 * Intermediare entre la base de données et php
 * @author: Omar CHIDA & Ali MIRMOHAMMADI & Louy MASSET
 * @date:16/02/2020
 * @version: 1.0
 *
 */

abstract class DAO
{
    /*cette classe est de type abstrait et singleton
    exemple d'implentation:
    class A extends Base
    {
    public function getName()
    {
        return 'A';
    }
    }
    exemple d'utilisation:
    echo A::getInstance()->getName(), "\n";
    */
    protected $BDD;
    private static $_instance = array();

    private function __construct()
    {
        $this->BDD= new SQLite3("BD.sqlite");
        $this->BDD.exec('create table if not exists Utilisateur (idutilisateur INTEGER PRIMARY KEY NOT NULL, pseudo VARCHAR(50) NOT NULL, prenom VARCHAR(50), nom VARCHAR(50),email VARCHAR(100) NOT NULL, mdp VARCHAR(50) NOT NULL)');

    }
    //Singletons should not be cloneable.
    protected function __clone() { }
    /*//Singletons should not be restorable from strings.
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }*/

    public static function getInstance(): DAO {
        $class = get_called_class();
        if(is_null(self::$_instance[$class])){
            self::$_instance[$class]=new $class();
        }
        return self::$_instance[$class];
    }
    //-----------------------------------functions abstraits
    public abstract function ajouterDansBDD($objet);
    public abstract function supprimerDeBDD($objet);
    public abstract function getByRequete($requete);
    public abstract function getBDD();


}