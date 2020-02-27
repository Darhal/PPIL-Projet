<?php
/*
 * Projet Procrast
 * Class Systeme
 * "Design Pattern"s: facade
 * @author: Ali MIRMOHAMMADI
 * @date:16/02/2020
 * @version: 1.0
 *
 */

include ('DAO.php');
include ('DAOUtilisateur.php');
include ('Utilisateur.php');
class systeme
{
    private $DAOUtil;
    public function __construct()
    {
        $this->DAOUtil = new DAOUtilisateur();


    }

}