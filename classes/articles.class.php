<?php

class articles {
    public $id;
    public $titre;
    public $texte;
    public $date;
    public $publie;

    function getId(){
        return $this->id;
    }

    function getTitre(){
        return $this->titre;
    }

    function getTexte(){
        return $this->texte;
    }

    function getDate(){
        return $this->date;
    }

    function getPublie(){
        return $this->publie;
    }

    function setId($id){
        return $this->id = $id;
    }

    function setTitre($titre){
        return $this->titre = $titre;
    }

    function setTexte($texte){
        return $this->texte = $texte;
    }

    function setDate($date){
        return $this->date = $date;
    }

    function setPublie($publie){
        return $this->publie = $publie;
    }

    public function hydrate($donnees){
        if (isset($donnees['id'])){
            $this->id = $donnees['id'];
        }else {
            $this->id = '';
        }

        if (isset($donnees['titre'])){
            $this->titre = $donnees['titre'];
        }else {
            $this->titre = '';
        }

        if (isset($donnees['texte'])){
            $this->texte = $donnees['texte'];
        }else {
            $this->texte = '';
        }

        if (isset($donnees['date'])){
            $this->date = $donnees['date'];
        }else {
            $this->date = '';
        }

        if (isset($donnees['publie'])){
            $this->publie = $donnees['publie'];
        }else {
            $this->publie = 0;
        }
    }
}