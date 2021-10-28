
    <?php  include 'includes/header.inc.php'; ?>
    <?php  include 'config/init.conf.php'; ?>
    <?php  include 'vendor/autoload.php'; ?>
    

    <?php 

    if(isset($_GET['id'])){
        $idArticle = ($_GET['id']);
        //echo " Vous modifiez l'article ";
        //echo $idArticle;
        $articlesManager = new articlesManager($bdd);
        $a = $articlesManager->get($idArticle);
    }else {
        echo "Vous avez ajouté un article ";
    }


    


    

    if (isset($_POST['submit'])) {
        //print_r2($_POST);
        //print_r2($_FILES);
        //exit();

        $article = new articles();
        $article->hydrate($_POST);

        $article->setDate(date('Y-m-d'));

        $publie = $article->getPublie() === 'on' ? 1 : 0;
   
        
        $article->setPublie($publie);
        //print_r2($article);
        //exit()
        $articlesManager = new articlesManager($bdd);

        if (empty($_POST['id'])){
            
            $articlesManager->add($article);
        }else {
            $articlesManager->update($article);
        }    
    
        //print_r2($_FILES);
        if($_FILES['image']['error'] == 0){
            $fileInfos = pathinfo($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'],
            'img/' . $articlesManager->get_getLastInsertId() . '.' . $fileInfos['extension']);
    
        }
    
        if($articlesManager->get_result() == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Votre article a été ajouté.';
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Une erreur est survenue';
        }
    
        header("Location: index.php");
         //exit();

    }else { 
        $article = new articles();
        $action = 'ajouter';
        
        $loader = new \Twig\Loader\FilesystemLoader('templates/includes/');
        $twig = new \Twig\Environment($loader, ['debug'=>true]);
        echo $twig->render('article.html.twig', []);
        
    


    
  
    ?>

        <!DOCTYPE html>
        <html lang="en">
        <!-- Responsive navbar-->
        <?php  include 'includes/menu.inc.php'; ?>
        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
                <div class="col-12">
                    <h1 class="font-weight-light"><?php echo "Hello World"?></h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                </div>
        

    <div class="container px-2 px-lg-5">
    <form enctype = "multipart/form-data" action="article.php" method="post">

    <div class="form-group">
        <?php if (isset($a)){?>
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" value="<?=$a->getTitre()?>">
      <?php }else {?>
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre">
      <?php } ?>
    </div>

    <br>
 
    <div class="form-group">
        <?php if (isset($a)){?>
        <label for="texte">Le texte de mon article</label>
        <textarea class="form-control" id="texte" name="texte" rows="3"><?=$a->getTexte()?></textarea>
        <?php }else {?>
        <label for="texte">Le texte de mon article</label>
        <textarea class="form-control" id="texte" name="texte" rows="3"></textarea>
        <?php } ?>
    </div>

    <br>
    <div class="form-check">
     <div class="form-group">
        <label for="exampleFormControlFile1">L'image de mon article</label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
        
        <?php if (isset($a)){?>
        <label class="form-check-label" for="publie">Article publié ?</label>
        <input type="checkbox" class="form-check-input" id="publie" name="publie" value="<?=$a->getPublie()?>">
        <?php }else {?>
        <label class="form-check-label" for="publie">Article publié ?</label>
        <input type="checkbox" class="form-check-input" id="publie" name="publie">
        <?php } ?>
        
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Ajouter mon article</button>
    <?php if (isset($a)){?>
    <div><input type="hidden" name="id" value="<?=$a->getId()?>"></div>
    <?php }else {}?>
    </form>

        

        </div>

    </div>

</div>


        <!-- Footer-->
        <?php  include 'includes/footer.inc.php'; ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

    
<?php 
?>
        

</html>

<?php } ?>