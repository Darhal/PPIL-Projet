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
                "idTache" => "INTEGER constraint Notification_Tache_idTache_fk references Tache",
                "destinataire" => "INTEGER constraint Notification_Utilisateur_idUtilisateur_fk references Utilisateur",
            )
        );
    }


    public function ajouterDansBDD($notif) : bool
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

        return $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    public function supprimerDeBDD($notif) : bool
    {
        return $this->BDD->deleteRow($this->tab_name, "idNotif = ".$notif->id);
    }

    public function getByRequete($requete) : array {
        return $this->BDD->fetchResults(self::$tab_name, "*", $requete);
    }

    public function getNotificationsTache(int $idUtilisateur) : array {
        $resSQL = self::getByRequete("destinataire = $idUtilisateur");

        $res_array = array();

        foreach ($resSQL as $item) {
            if($item['nature'] == "tache"){
                $notif = new NotificationListeTaches($item['msg'], $item['statut'], $item['idListe'], $item['destinataire']);
                $notif->idNotif = $item['idNotif'];
                $notif->idTache = $item['idTache'];

                array_push($res_array, $notif);
            }
        }

        return $res_array;
    }
    public function getNotificationsListeTache(int $idUtilisateur) : array {
        $resSQL = self::getByRequete("destinataire = $idUtilisateur");

        $res_array = array();

        foreach ($resSQL as $item) {
            if($item['nature'] == "liste"){
                $notif = new NotificationListeTaches($item['msg'], $item['statut'], $item['idListe'], $item['destinataire']);
                $notif->idNotif = $item['idNotif'];

                array_push($res_array, $notif);
            }
        }
    }


    public function updateBDD($notif, $condition = "") : bool
    {
        $attribs = array(); // TODO: JUST FINISH THIS (Look at DAOUtilisateur and get some inspiration from there)
        $res = $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
        return $res;
    }
}