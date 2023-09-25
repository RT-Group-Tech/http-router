<?php
/**
 * Ce fichier est le point d'entrée unique de l'application.
 * Toutes les requetes https lui sont redirigées.
 */

/**
 * Lancer le router.
 */
    require_once ("./vendor/autoload.php");

    use Rtgroup\HttpRouter\HttpRouter;
    echo "start..";
    ?><pre><?php print_r($_SERVER);?></pre><?php


    $router=new HttpRouter();
    require_once("./controllers/Connexion.php");

    $router->listening(array(
        "/connexion/login"
    ),new Connexion());

?>
