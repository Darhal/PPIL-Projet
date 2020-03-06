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

    public function ajouterDansBDD($listeTache){
        $attribs = array(
            "idListe" => $listeTache->id,
            "nom" => $listeTache->nom,
            "dateDebut" => $listeTache->dateDebut,
            "dateFin" => $listeTache->dateFin,
            "idUtilisateur" => $listeTache->responsable
        );
        $this->BDD->insertRow(self::$tab_name, $attribs);
    }


    public function supprimerDeBDD($objet){
        //TODO
    }

    public function getByRequete($requete){
        return $this->BDD->fetchResults("Liste", "*", $requete);;
    }



}