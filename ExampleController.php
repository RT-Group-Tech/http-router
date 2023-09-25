<?php

class ExampleController extends \Rtgroup\HttpRouter\Controller
{

    public function captured($url)
    {
        echo "\nContent called:".$url;
    }
}