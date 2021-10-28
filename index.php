<?php  require_once 'config/init.conf.php';
       require_once 'config/bdd.conf.php';

       $articlesManager = new articlesManager($bdd);
       define('__nb_articles_par_page', 2);
       $page  = !empty($_GET ['p']) ? $_GET['p'] : 1; //Si $_GET P est différent de vide alors $page= la valeur de la page sinon $page = 1
       $nbArticlesTotalPublie = $articlesManager->countArticlesPublie();
       $nbPages = ceil($nbArticlesTotalPublie / __nb_articles_par_page);
       $indexDepart = ($page - 1) * __nb_articles_par_page;
       $listArticle = $articlesManager->getListArticlesAAfficher($indexDepart, __nb_articles_par_page);
       
       
        $articles = $bdd->query('SELECT titre, texte, id FROM articles ORDER BY id DESC');

        if(isset($_GET['q']) AND !empty($_GET['q'])) {
            $q = htmlspecialchars($_GET['q']);
            $articles = $bdd->query('SELECT titre, texte, id FROM articles WHERE titre LIKE "%'.$q.'%" OR texte LIKE  "%'.$q.'%" ' );
        if($articles->rowCount() == 0) {
            $articles = $bdd->query('SELECT titre FROM articles WHERE CONCAT(titre, texte) LIKE "%'.$q.'%" ORDER BY id DESC');
        }
        }

       
        //print_r($listArticle);
       //__nb_articles_par_page;
    

?>


<!DOCTYPE html>
<html lang="en">

    <?php include 'includes/header.inc.php';?>
    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/menu.inc.php';?>
        
        <!-- Page Content-->

        <?php
            if (isset($_SESSION['notification'])){
        ?>
            <div class="alert alert-<?= $_SESSION['notification']['result'] ?> alert-dismissible mt-3" role="alert">
                <?= $_SESSION['notification']['message'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </div>
            <?php
            unset($_SESSION['notification']);
            }
        ?>

<form method="GET">
        <input type="search" name="q" placeholder="Recherche..." />
        <input type="submit" value="Valider" />
</form>

    <?php if(!empty($q)) { ?>

       <?php while($a = $articles->fetch()) { ?>
            <li>
                <div class="container px-5 px-lg-0">
                    <div class="row gx-4 gx-lg-5 align-items-center my-5">
                        <div class="col-md-4 mb-5">
                            <div class="card h-100">
                            <img src = "img/<?= $a['id'] ?>.gif">
                                <div class="card-body">
                                    <h2 class="card-title"><?= $a['titre'] ?></h2>
                                    <p class="card-text"><?= $a['texte'] ?></p>
                                    <div class="card-footer"><a class="btn btn-primary btn-sm" href="article.php?id=<?= $a['id']?>">Modifier l'article</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
       <?php } ?>

    <?php } else { ?>

    <?php } ?>

        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
                <div class="col-lg-12">
                    <h1 class="font-weight-light"><?php echo "hello world" ?> </h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                    
                </div>
            </div>
            
            <!-- Content Row-->
            <div class="row gx-4 gx-lg-5">
                <?php                        
                foreach ($listArticle as $key => $articles) {
                ?>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                    <img src = "img/<?= $articles->getId()?>.gif">
                        <div class="card-body">
                            <h2 class="card-title"><?= $articles->getTitre()?></h2>
                            <p class="card-text"><?= $articles->getTexte()?></p>
                        </div>
                        <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!"><?= $articles->getDate()?></a></div>
                        <div class="card-footer"><a class="btn btn-primary btn-sm" href="article.php?id=<?= $articles->getId()?>">Modifier l'article</a></div>
                    </div>
                </div>
                <?php

                }
                ?>
            </div>


        </div>
<div class="row mt-3">
    <div class="col-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

            <?php for ($index = 1; $index <= $nbPages; $index++) { ?>
                <li class="page-item <?php if ($page == $index) { ?>active<?php } ?>">
                <a class="page-link" href="index.php?p=<?= $index ?>"><?= $index ?></a>
                </li>
                     <?php 
                        }
                    ?>
            </ul>
        </nav>
    </div>
</div>


    
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
