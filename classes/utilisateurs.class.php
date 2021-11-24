<?php 

class utilisateurs {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $sid;


    function getId(){
        return $this->id;
    }

    function getNom(){
        return $this->nom;
    }

    function getPrenom(){
        return $this->prenom;
    }

    function getEmail(){
        return $this->email;
    }

    function getMdp(){
        return $this->mdp;
    }

    function getSid(){
        return $this->sid;
    }

    function setId($id){
        return $this->id = $id;
    }

    function setNom($nom){
        return $this->nom = $nom;
    }

    function setPrenom($prenom){
        return $this->prenom = $prenom;
    }

    function setEmail($email){
        return $this->email = $email;
    }

    function setMdp($mdp){
        return $this->mdp = $mdp;
    }

    function setSid($sid){
        return $this->sid = $sid;
    }

    public function hydrate($donnees){
        if (isset($donnees['id'])){
            $this->id = $donnees['id'];
        }else {
            $this->id = '';
        }

        if (isset($donnees['nom'])){
            $this->nom = $donnees['nom'];
        }else {
            $this->nom = '';
        }

        if (isset($donnees['prenom'])){
            $this->prenom = $donnees['prenom'];
        }else {
            $this->prenom = '';
        }

        if (isset($donnees['email'])){
            $this->email = $donnees['email'];
        }else {
            $this->email = '';
        }

        if (isset($donnees['mdp'])){
            $this->mdp = $donnees['mdp'];
        }else {
            $this->mdp = '';
        }

        if (isset($donnees['sid'])){
            $this->sid = $donnees['sid'];
        }else {
            $this->sid = '';
        }
    }


    



}
