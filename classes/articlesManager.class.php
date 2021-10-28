<?php 

class articlesManager{

    //Déclarations et instanciations
    private $bdd;
    private $_result;
    private $_message;
    private $_articles;
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

    function get_message(){
        return $this->_message;
    }

    function get_articles(){
        return $this->_articles;
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

    function set_articles($_articles){
        return $this->_articles = $_articles;
    }

    function set_getLastInsertId($_getLastInsertId){
        return $this->_getLastInsertId = $_getLastInsertId;
    }

    public function get($id){
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //Exécution de la requête avec attribution des valeurs aux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $articles = new articles();
        $articles->hydrate($donnees);
        return $articles;
    } 

    public function add(articles $articles){
        $sql = "INSERT INTO articles " . "(titre, texte, publie, date)" . "VALUES (:titre, :texte, :publie, :date)";

        $req = $this->bdd->prepare($sql);

        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);

        $req->execute();
        if($req->errorCode() == 00000) {
            $this->_result = true;
            $this->get_getLastInsertId =$this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    public function countArticlesPublie(){
        $sql = "SELECT COUNT(*) as total FROM articles";

        $req = $this->bdd->prepare($sql);
        $req->execute();

        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }

    public function getListArticlesAAfficher($depart, $limit){
        $listArticle = [] ;

        $sql = 'SELECT id, ' .'titre, ' .'texte, ' .'publie, ' .'DATE_FORMAT(date, "%d/%m/%Y") as date ' .'FROM articles LIMIT :depart, :limit';
        $req = $this->bdd->prepare($sql);

        $req ->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req ->bindValue(':limit', $limit, PDO::PARAM_INT);


        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)){
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        return $listArticle;
    }

    public function update(articles $articles) {
        $sql = "UPDATE articles SET " . "titre = :titre," . "texte = :texte," . "publie = :publie" . " WHERE id = :id";
        $req = $this->bdd->prepare($sql);

        // Sécurisation des variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_STR);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_STR);

        // Exécution de la requête
        $req->execute();
        if($req->errorCode()== 00000) {
            $this->_result = true;
        }

        else {
            $this->_result = false;
        }
        return $this;
    }

    public function getListArticlesFromRechercher($recherche) {
        $sql = 'SELECT id, ' . 'titre, ' . 'texte, ' . 'publie, ' . 'DATE_FORMAT(date, "%d/%m/%Y") as date ' . 'FROM articles ' . 'WHERE publie = 1 ' . 'AND (titre LIKE recherche ' . 'OR texte LIKE : recherche)';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);

        $req->execute();

        while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        return ListArticle;
    }
    
    
}