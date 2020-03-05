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

include_once getenv('BASE')."Shared/Libraries/BDD.php";

abstract class DAO
{
    private static $_instances = array();
    private static $DEFAULT_DB_FILE = "db.sql";
    protected $BDD;

    protected function __construct($db_name)
    {
        $this->BDD = new BDD($db_name == "" ? self::$DEFAULT_DB_FILE : $db_name);
    }

    // Singletons should not be cloneable.
    protected function __clone() { }

    public static function getInstance() {
        $class = get_called_class();

        if(!isset(self::$_instances[$class])){
            self::$_instances[$class] = new $class();
        }

        return self::$_instances[$class];
    }

    public function getBDD()
    {
        return $BDD;
    }

    //-----------------------------------functions abstraits
    public abstract function ajouterDansBDD($objet);
    public abstract function supprimerDeBDD($objet);
    public abstract function getByRequete($requete);
}

?>