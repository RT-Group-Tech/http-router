<?php
namespace Rtgroup\HttpRouter;

use Exception;

class HttpRouter
{
    public function __construct()
    {

        $req=new HttpRequest();
        try
        {
            HttpRequest::checkRequiredData("fullname");
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}