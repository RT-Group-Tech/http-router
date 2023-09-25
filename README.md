# http-router

<?php
<h2>Installation:</h2>
composer require rtgroup/http-router

<h2>Usage:</h2>
use Rtgroup\HttpRouter\HttpRouter;<br>
use Rtgroup\HttpRouter\UrlNotFound;<br>

require_once "vendor/autoload.php";<br>

    try<br>
    {<br>
        $router=new HttpRouter();<br>
        require_once "ExampleController.php";<br>

        <p>$router->listening(array(<br>
                    "content/view",<br>
                    "/http-router/index.php"<br>
                    ),new ExampleController())<br>
            $router->close(); //fermer le routeur pour capturer toutes les erreurs http</p>

    }catch (UrlNotFound $e)<br>
    {<br>
        echo $e->getMessage();<br>
    }<br>

?>
