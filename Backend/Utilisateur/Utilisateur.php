<?php
/*
 * Projet Procrast
 * Class Utilisateur
 * @author: Ali MIRMOHAMMADI & Jonathan Pierrel
 * @date:16/02/2020
 * @version: 1.0
 */

class Utilisateur
{
    public $id;
    public $pseudo;
    public $prenom;
    public $nom;
    public $email;
    public $mdp;

    function __construct($pseudo, $prenom, $nom, $email, $mdp)
    {
        $this->pseudo = $pseudo;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
    }

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}
}