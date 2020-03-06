<?php
/*
 * Projet Procrast
 * Classe DAOTache
 * L'implentation de "Design Pattern"s: Data access object, Singleton
 * Intermediare entre la base de données et php pour les données qui concernent la classe Tache
 * @author: Jonathan Pierrel
 * @date:05/03/2020
 * @version: 1.0
 *
 */

include_once getenv('BASE')."Shared/Libraries/BDD.php";
include_once getenv('BASE')."Backend/Taches/Tache.php";


class DAOTache extends DAO
{
    private static $tab_name = "Tache";
    private static $tab_name2 = "Affecte";
    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->BDD->createTable(self::$tab_name,
            array(
                "idTache" => "INTEGER PRIMARY KEY NOT NULL",
                "nom" => "VARCHAR NOT NULL",
                "statut" => "VARCHAR",
//               "INTEGER FOREIGN KEY(Liste) NOT NULL"
//            A ADAPTER en fonction de https://www.sqlite.org/foreignkeys.html pour la foregin key
            )
        );


        $this->BDD->createTable(self::$tab_name2,
            array(
                // TODO:
                // a faire. Verifier comment faire lorsque c'est des clés etrangères

            )
        );
    }

    public function ajouterDansBDD($tache){
        //TODO:
        // Vérifier que c'est bien les bon noms utilisés par la BDD
        $attribs = array(
            "idTache" => $tache->id,
            "nom" => $tache->nom,
            "statut" => $tache->finie,
            "idListe" => $tache->idListe,

        );
        $this->BDD->insertRow(self::$tab_name, $attribs);
    }

    public function supprimerDeBDD($objet){
        //TODO
    }

    public function getByRequete($requete){
        return $this->BDD->fetchResults("Tache", "*", $requete);;
    }
}