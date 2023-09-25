<?php
namespace Rtgroup\HttpRouter;

use Exception;

class HttpRouter
{
    public function __construct()
    {

        $req=new HttpRequest();

        $url=$req->getUrl();

        echo $url;
    }
}