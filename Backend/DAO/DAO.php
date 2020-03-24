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
set_include_path(getenv('BASE'));
include_once "Shared/Libraries/BDD.php";

abstract class DAO
{
    private static $_instances = array();
    private static $DEFAULT_DB_FILE = "db.sqlite";
    protected $BDD;

    protected function __construct($bdd = null)
    {
        if ($bdd == null) {
            $bdd = new BDD(self::$DEFAULT_DB_FILE);
        }

        $this->BDD = $bdd;
    }

    // Singletons should not be cloneable.
    protected function __clone() { }

	/** @noinspection PhpUnused */
	public static function getInstance() {
        $class = get_called_class();

        if(!isset(self::$_instances[$class])){
            self::$_instances[$class] = new $class();
        }

        return self::$_instances[$class];
    }
    //Jamais Appelée
    /*public function getBDD()
    {
        return $BDD;
    }*/

    //-----------------------------------functions abstraits
    public abstract function ajouterDansBDD($objet);
    public abstract function supprimerDeBDD($objet);
    public abstract function getByRequete($requete);
    public abstract function updateBDD($objet, $condition = "");
}