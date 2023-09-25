<?php

use Rtgroup\HttpRouter\HttpRouter;
use Rtgroup\HttpRouter\UrlNotFound;

require_once "vendor/autoload.php";

    try
    {
        $router=new HttpRouter();
        require_once "ExampleController.php";

        $router->listening(array(
                    "content/view",
                    "/http-router/index.php"
                    ),new ExampleController())
            ->close();

    }catch (UrlNotFound $e)
    {
        echo $e->getMessage();
    }

?>
