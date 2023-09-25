<?php
namespace Rtgroup\HttpRouter;

class HttpRouter
{
    public function __construct()
    {

        $req=new HttpRequest();
        $host=$req->getHost();
        echo "Host:".$host."\n";

        ?>
        <pre><?php print_r($_SERVER); ?></pre>
        <?php
    }
}