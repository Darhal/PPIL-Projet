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

class DAONotif extends DAO
{
    private static $tab_name = "Notification";

    public function __construct($bdd = null)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idNotif" => "INTEGER constraint Notification_pk primary key autoincrement",
                "msg" => "varchar not null",
                "statut" => "varchar not null",
                "nature" => "varchar not null",
                "idListe" => "INTEGER constraint Notification_Liste_idListe_fk references Liste",
                "idTache" => "INTEGER constraint Notification_Tache_idTache_fk references Tache"
            )
        );
    }


    public function ajouterDansBDD($notif)
    {
        $attribs = array(
            "idNotif" => $notif->id,
            "msg" => $notif->msg,
            "statut" => $notif->statut,
            "nature" => $notif->nature
        );

        if($notif->liste != null){
            $attribs["idListe"] = $notif->liste->id;
        }

        if($notif->tache != null){
            $attribs["idTache"] = $notif->tache->id;
        }

        $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    public function supprimerDeBDD($objet)
    {
        // TODO: Implement supprimerDeBDD() method.
    }

    public function getByRequete($requete)
    {
        // TODO: Implement getByRequete() method.
    }
}