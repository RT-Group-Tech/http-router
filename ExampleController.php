<?php

class ExampleController extends \Rtgroup\HttpRouter\HttpEvent
{

    public function captured($url)
    {
        echo "\nContent called:".$url;
    }
}