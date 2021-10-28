<?php

class utilisateursManager{

    //Déclarations et Instanciations
    private $bdd;
    private $_result;
    private $_utilisateurs;
    private $_message;
    private $_getLastInsertId;

    public function __construct(PDO $bdd){
        $this->setBdd($bdd);
    }

    function getBdd(){
        return $this->bdd;
    }

    function get_result(){
        return $this->_result;
    }

    function get_utilisateurs(){
        return $this->_utilisateurs;
    }

    function get_message(){
        return $this->_message;
    }

    function get_getLastInsertId(){
        return $this->get_getLastInsertId;
    }

    function setBdd($bdd){
        return $this->bdd = $bdd;
    }

    function set_result($_result){
        return $this->_result = $_result;
    }

    function set_message($_message){
        return $this->_message = $_message;
    }

    function set_articles($_utilisateurs){
        return $this->_utilisateurs = $_utilisateurs;
    }

    function set_getLastInsertId($_getLastInsertId){
        return $this->_getLastInsertId = $_getLastInsertId;
    }

    public function get($id){
        $sql = 'SELECT * FROM utilisateurs WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //Exécution de la requête avec attribution des valeurs aux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        return $utilisateurs;
    } 

    public function addUser(utilisateurs $utilisateurs){
        $sql = "INSERT INTO utilisateurs " . "(nom, prenom, email, mdp)" . "VALUES (:nom, :prenom, :email, :mdp)";

        $req = $this->bdd->prepare($sql);

        $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);

        $req->execute();
        if($req->errorCode() == 00000) {
            $this->_result = true;
            $this->get_getLastInsertId =$this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    public function getByEmail($email){
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);

        return $utilisateurs;
    }

    public function getBySid($sid){
        $sql = "SELECT * FROM utilisateurs WHERE sid = :sid";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);

        return $utilisateurs;
    }

    public function updateByEmail(utilisateurs $utilisateurs){
        $sql = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue('sid', $utilisateurs->getSid(), PDO::PARAM_STR);

        $req->execute();
        if ($req->errorCode() == 00000){
            $this->_result = true;
        }else{
            $this->_result = false;
        }
        return $this;
    }

}