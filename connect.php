<?php 

require_once 'config/init.conf.php';
require_once "vendor/autoload.php";

 ?>

<?php
if(isset($_POST['submit'])){

    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);

    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateurs->getEmail());

    //$isConnect = password_verify($utilisateurs->getMdp(), $utilisateursEnBdd->getMdp());
    $pass1 = $utilisateurs->getMdp();
    $pass2 = $utilisateursEnBdd->getMdp();

    if ($pass1==$pass2){
        $sid = md5($utilisateurs->getEmail() . time());
        setCookie('sid', $sid, time() + 86400);
        $utilisateurs->setSid($sid);
        $utilisateursManager->updateByEmail($utilisateurs);
    }

    if($pass1==$pass2) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Vous êtes connecté.';
        header("Location: index.php");
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Une erreur est survenue';
        header("Location: connect.php");
    }   

}else {
    $utilisateurs = new utilisateurs();
    $action = 'ajouter';

    $loader = new \Twig\Loader\FilesystemLoader('templates/includes/');
    $twig = new \Twig\Environment($loader, ['debug'=>true]);
    echo $twig->render('connect.html.twig', []);
}


?>

