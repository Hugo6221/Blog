<?php 

require_once 'config/init.conf.php'; 
require_once 'vendor/autoload.php';
?>

<?php
if(isset($_POST['submit'])){

    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);

    $utilisateursManager = new utilisateursManager($bdd);

    $utilisateursManager->addUser($utilisateurs);

    if($utilisateursManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Votre compte a été ajouté.';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Une erreur est survenue';
    }
    
    header("Location: index.php");

}else {
    $utilisateurs = new utilisateurs();
    $action = 'ajouter';

    $loader = new \Twig\Loader\FilesystemLoader('templates/includes/');
    $twig = new \Twig\Environment($loader, ['debug'=>true]);
    echo $twig->render('form_connect.html.twig', []);
}

?>