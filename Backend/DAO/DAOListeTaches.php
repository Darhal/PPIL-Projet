<?php
/*
 * Projet Procrast
 * Classe DAOListeTaches
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les donnees qui concernent la classe ListeTaches
 * @author: Jonathan Pierrel
 * @date:05/03/2020
 * @version: 1.0
 *
 */

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Taches/ListeTaches.php";


class DAOListeTaches extends DAO
{
    private static $tab_name = "Liste";

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idListe" => "INTEGER constraint Liste_pk primary key autoincrement",
                "nom" => "nom varchar not null",
                "dateDebut" => "date not null",
                "dateFin" => "date",
                "idUtilisateur" => "int constraint fk_idu references Utilisateur"
            )
        );
    }

    public function ajouterDansBDD($liste) : bool {
        $attribs = array(
            "nom" => $liste->nom,
            "dateDebut" => $liste->dateDebut,
            "dateFin" => $liste->dateFin
        );

        if($liste->dateFin != null){
            $attribs["dateFin"] = $liste->dateFin;
        }

        if($liste->proprietaire != null){
            $attribs["idUtilisateur"] = $liste->proprietaire;
        }

        return $this->BDD->insertRow(self::$tab_name, $attribs);
    }


    public function supprimerDeBDD($liste) : bool {
        // Incomplet (ne supprime pas les tâches)
        return $this->BDD->deleteRow($this->tab_name, "idListe = ".$liste->id);
    }

    public function getByRequete($requete) : array {
        return $this->BDD->fetchResults(self::$tab_name, "*", $requete);
    }

    public function getListeTachesByID(int $id) : array
    {
        return $this->getByRequete("idListe = $id");
    }

    public function getListesTachesByUserID(int $id) : array
    {
        return $this->getByRequete("idUtilisateur = $id");
    }


    public function updateBDD($liste_tache, $condition = "") : bool
    {
        $attribs = array(
            "idListe" => $liste_tache->id,
            "nom" => $liste_tache->nom,
            "dateDebut" => $liste_tache->dateDebut,
            "dateFin" => $liste_tache->dateFin,
            "idUtilisateur" => $liste_tache->proprietaire

        );
        $res = $this->BDD->updateRow(self::$tab_name, $attribs, $condition);
        return $res;
    }

    public function update(ListeTaches $liste):bool
    {
        return $this->updateBDD($liste, "idListe == $liste->id");
    }
}