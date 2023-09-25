<?php

class ExampleController extends \Rtgroup\HttpRouter\HttpEvent
{

    public function capture($url)
    {
        echo "\nContent called:".$url;
    }
}