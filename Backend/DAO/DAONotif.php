<?php
/*
 * Projet Procrast
 * Classe DAONotification
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les donnees qui concernent les extensions de la classe Notification
 * @author: Ali MIRMOHAMMADI
 * @date:05/03/2020
 * @version: 1.0
 *
 */
include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Utilisateur/Utilisateur.php";
include_once getenv('BASE')."Backend/DAO/DAO.php";

class DAONotif
{
    private static $tab_name = "Notification";

    public function __construct($bdd = null)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idNotif" => "INTEGER PRIMARY KEY NOT NULL",
                "msg" => "VARCHAR NOT NULL",
                "statut" => "VARCHAR",
                "nature" => "VARCHAR",
                "idListe" => "INTEGER",
                "idTache" => "INTEGER"
            ), 
            array(
                "idListe" => array("Liste", "idListe", "ON DELETE CASCADE"),
                "idTache" => array("Tache", "idTache", "ON DELETE CASCADE"),
            )
        );
        //DONE: OMARR :il faut ajouter les contraintes pour clés étrangers (id Liste et idTache)en precisant ON DELETE <mode>
        //FOREIGN KEY(idListe) REFERENCES Liste(idListe) ON DELETE CASCADE,
        //FOREIGN KEY(idTache) REFERENCES Tache(idTache) ON DELETE CASCADE
    }
}